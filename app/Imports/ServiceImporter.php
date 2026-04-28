<?php

namespace App\Imports;

use App\Enums\ServiceCategoryEnum;
use App\Models\ServiceCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Throwable;

class ServiceImporter implements ToCollection,
    WithChunkReading,
    WithStartRow,
    WithBatchInserts
{

    public function __construct(private array $map = [])
    {
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function startRow(): int
    {
        return 2;
    }

    /**
     * @throws Throwable
     */
    public function collection(Collection $collection): void
    {
        $rows = $collection->toArray();

        if (empty($rows)) {
            return;
        }

        if (!$this->map) {
            $header = array_map('trim', $rows[0] ?? []);
            $this->map = array_flip($header);

            array_shift($rows);
        }

        $this->processBatch($rows);
    }

    /**
     * @throws Throwable
     */
    protected function processBatch(
        array $rows): void
    {
        DB::transaction(function () use ($rows) {
            try {
                $now = now();

                $names = array_unique(array_column($rows, 0));

                $categories = ServiceCategory::query()
                    ->whereIn('name', $names)
                    ->get()
                    ->keyBy('name');

                $services = [];

                foreach ($rows as $row) {
                    $type = $row[0];
                    $serviceCategory = $categories[$type] ?? null;

                    if (!$serviceCategory) {
                        continue;
                    }

                    $isLocal = $type == ServiceCategoryEnum::Local->value;

                    $services[] = [
                        'service_category_id' => $serviceCategory->id,
                        'name' => $row[1],
                        'price' => $row[2],
                        'requires_diagnosis' => $isLocal,
                        'requires_visit' => !$isLocal,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if (!empty($services)) {
                    DB::table('services')->upsert(
                        $services,
                        ['name', 'service_category_id'],
                        []
                    );
                }

            } catch (Throwable $e) {
                Log::error('Error en batch', [
                    'error' => $e->getMessage(),
                ]);
                throw $e;
            }
        });
    }
}

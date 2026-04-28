<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Throwable;

class ClientImporter implements ToCollection,
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
    protected function processBatch(array $rows): void
    {
        DB::transaction(function () use ($rows) {
            $clients = [];
            $now = now();

            foreach ($rows as $row) {
                $clients[] = [
                    'name' => $row['1'],
                    'last_name' => "{$row['2']} {$row['3']}",
                    'address' => $row['6'],
                    'phone' => $row['7'],
                    'city' => $row['8'],
                    'postal_code' => $row['9'],
                    'email' => $row['10'],
                    'rfc' => $row['11'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('clients')->upsert($clients, ['email', 'phone', 'rfc'], []);
        });
    }
}

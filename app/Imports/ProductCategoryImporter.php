<?php

namespace App\Imports;

use App\Models\DeviceCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductCategoryImporter implements ToModel,
    WithChunkReading,
    WithStartRow,
    WithBatchInserts
{

    public function model(array $row): DeviceCategory
    {
        return new DeviceCategory([
            'name' => $row['0'],
        ]);
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
}

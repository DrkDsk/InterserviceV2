<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ClientImporter implements ToModel,
    WithChunkReading,
    WithStartRow,
    WithBatchInserts
{

    public function model(array $row): Client
    {
        return new Client([
            'name' => $row['1'],
            'last_name' => "{$row['2']} {$row['3']}",
            'address' => $row['6'],
            'phone' => $row['7'],
            'city' => $row['8'],
            'postal_code' => $row['9'],
            'email' => $row['10'],
            'rfc' => $row['11']
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

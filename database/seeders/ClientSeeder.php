<?php

namespace Database\Seeders;

use App\Imports\ClientImporter;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new ClientImporter, base_path("database/data/clientes.csv"));
    }
}

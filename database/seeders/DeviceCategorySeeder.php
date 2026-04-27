<?php

namespace Database\Seeders;

use App\Imports\ProductCategoryImporter;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DeviceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new ProductCategoryImporter, base_path("storage/app/imports/tablaEquipos.csv"));
    }
}

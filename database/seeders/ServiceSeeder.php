<?php

namespace Database\Seeders;

use App\Imports\ServiceImporter;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new ServiceImporter, base_path("storage/app/imports/precios/PRECIOS_CPU.csv"));
        Excel::import(new ServiceImporter, base_path("storage/app/imports/precios/PRECIOS_PORTATILES.csv"));
        Excel::import(new ServiceImporter, base_path("storage/app/imports/precios/PRECIOS_IMPRESORAS.csv"));
        Excel::import(new ServiceImporter, base_path("storage/app/imports/precios/PRECIOS_SISTEMASDEPUNTODEVENTA.csv"));
        Excel::import(new ServiceImporter, base_path("storage/app/imports/precios/PRECIOS_OTROSSERVICIOS_LOCALES.csv"));
        Excel::import(new ServiceImporter, base_path("storage/app/imports/precios/PRECIOS_REDESEINTERNET.csv"));
        Excel::import(new ServiceImporter, base_path("storage/app/imports/precios/PRECIOS_SERVICIOSCAMARAS_CCTV.csv"));
        Excel::import(new ServiceImporter, base_path("storage/app/imports/precios/PRECIOS_ENLACESDEINTERNET.csv"));
        Excel::import(new ServiceImporter, base_path("storage/app/imports/precios/PRECIOS_OTROSSERVICIOS_FORANEOS.csv"));
    }
}

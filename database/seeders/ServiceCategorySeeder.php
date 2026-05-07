<?php

namespace Database\Seeders;

use App\Enums\ServiceCategoryType;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $localPrices = [
            'CPU',
            'PORTÁTILES',
            'IMPRESORAS',
            'SISTEMAS DE PUNTO DE VENTA',
            'OTROS SERVICIOS LOCALES'
        ];

        $foreignPrices = [
            'REDES E INTERNET',
            'SERVICIOS DE CÁMARAS CCTV',
            'ENLACES DE INTERNET',
            'OTROS SERVICIOS FORÁNEOS'
        ];

        foreach ($localPrices as $name) {
            ServiceCategory::query()->create([
                'name' => $name,
                'type' => ServiceCategoryType::Local->value
            ]);
        }

        foreach ($foreignPrices as $name) {
            ServiceCategory::query()->create([
                'name' => $name,
                'type' => ServiceCategoryType::Remote->value
            ]);
        }
    }
}

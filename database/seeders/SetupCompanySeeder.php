<?php

namespace Database\Seeders;

use App\Models\SetupCompany;
use Illuminate\Database\Seeder;

class SetupCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SetupCompany::query()->create([
            'facebook' => 'Interservice',
            'email' => 'admin@gmail.com',
            'WhatsApp' => '1234567890',
            'phone' => '1234567890',
            'location' => 'Calle 123 # 45-67',
            'city' => 'Tonalá, Chiapas',
        ]);
    }
}

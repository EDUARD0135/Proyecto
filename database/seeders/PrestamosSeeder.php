<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prestamo;

class PrestamosSeeder extends Seeder
{

    public function run(): void
    {
        Prestamo::factory()->count(100)->create();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Libro;

class LibrosSeeder extends Seeder
{

    public function run(): void
    {
        Libro::factory()->count(500)->create();
    }
}

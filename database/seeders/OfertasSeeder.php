<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Oferta;

class OfertasSeeder extends Seeder
{
    
    public function run(): void
    {
        Oferta::factory()->count(30)->create();
    }
}

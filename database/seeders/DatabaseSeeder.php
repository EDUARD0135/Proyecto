<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Oferta;
use App\Models\Usuario;
use App\Models\Producto;

class DatabaseSeeder extends Seeder
{
   
    public function run(): void
    {
        $this->call(UsuariosSeeder::class);
        $this->call(OfertasSeeder::class);
        $this->call(ProductosSeeder::class);
    }
}

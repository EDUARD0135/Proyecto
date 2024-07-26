<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;


class UsuariosSeeder extends Seeder
{

    public function run()
    {
    
        Usuario::factory()->create([
            'nombre' => 'Lucem',
            'apellido' => 'Admin',
            'email' => 'lucem.store50@gmail.com',
            'nombre_usuario' => 'LucemAdmin',
            'contrasena' => bcrypt('LucemAdmin'),
            'telefono' => '95114411',
            'rol' => 'admin',
            'activo' => true,
            'imagen' => null,
        ]);

        Usuario::factory(30)->create();
       
    }
}

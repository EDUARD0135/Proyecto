<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

class UsuarioFactory extends Factory
{
   
    public function definition(): array
    {
        
        $image1 = 'https://img.freepik.com/fotos-premium/dulces-redondos-multicolores-sobre-fondo-blanco_461160-5600.jpg?w=1060';

        return [
            'nombre' =>fake()->firstName(),
            'apellido' =>fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'nombre_usuario' => fake()->unique()->userName(),
            'contrasena' => bcrypt('123456'), // Puedes cambiar 'password' por cualquier otra contraseña que desees
            'telefono' => fake()->numerify('########'),
            'rol' => 'usuario',
            'activo' => true,
            'imagen' =>  $image1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

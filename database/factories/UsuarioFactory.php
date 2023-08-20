<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

/*
      $table->string('nombre');
      $table->string('correo_electronico');
      $table->integer('teléfono');
      $table->string('direccion');
*/

class UsuarioFactory extends Factory
{
   
    public function definition(): array
    {
        return [
            'nombre'=>fake()->name(),
            'correo_electronico'=>fake()->Email(),
            'teléfono'=>fake()->numerify('########'),
            'direccion'=>fake()->word()
        ];
    }
}

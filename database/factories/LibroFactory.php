<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Libro;

/*
     $table->string('titulo');
            $table->string('autor');
            $table->integer('editorial');
            $table->integer('año_publicacion');
            $table->integer('cantidad_disponible');
*/

class LibroFactory extends Factory
{

    public function definition(): array
    {
        return [
            'titulo'=>fake()->name(),
            'autor'=>fake()->name(),
            'editorial'=>fake()->name(),
            'año_publicacion'=>fake()->numberBetween(1980,2023),
            'cantidad_disponible'=>fake()->numberBetween(1,100)
        ];
    }
}

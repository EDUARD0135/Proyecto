<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prestamo;

/*
            $table->datetime('fecha_solicitud');
            $table->datetime('fecha_prestamo');
            $table->datetime('fecha_devolucion');
            $table->unsignedBigInteger('libro_id');
            $table->unsignedBigInteger('usuario_id');
*/

class PrestamoFactory extends Factory
{
  
    public function definition(): array
    {
        return [
            'fecha_solicitud'=>fake()->date(),
            'fecha_prestamo'=>fake()->date(),
            'fecha_devolucion'=>fake()->date(),
            'libro_id'=>fake()->numberBetween(1,500),
            'usuario_id'=>fake()->numberBetween(1,500)
        ];
    }
}

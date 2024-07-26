<<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email');
            $table->string('nombre_usuario')->unique();
            $table->string('contrasena');
            $table->integer('telefono');
            $table->string('rol')->default('usuario');
            $table->boolean('activo')->default(true);
            $table->binary('Imagen')->nullable(); // Cambiado a binary
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

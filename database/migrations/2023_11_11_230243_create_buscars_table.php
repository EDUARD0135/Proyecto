<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('buscars', function (Blueprint $table) {
            $table->id();
            $table->string('term');
            $table->integer('count')->default(1);
            $table->binary('Imagen')->nullable(); // Cambiado a binary
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buscars');
    }
};

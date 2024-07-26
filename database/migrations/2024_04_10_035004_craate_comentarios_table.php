<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
    Schema::create('comentarios', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('producto_id')->nullable();
        $table->unsignedBigInteger('oferta_id')->nullable();
        $table->unsignedBigInteger('usuario_id');
        $table->text('contenido');
        $table->timestamps();

        $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        $table->foreign('oferta_id')->references('id')->on('ofertas')->onDelete('cascade');
        $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
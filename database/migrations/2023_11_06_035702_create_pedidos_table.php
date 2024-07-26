<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->enum('categoria',['Camisas', 'Pantalones', 'Zapatos','Dulces','Postres','Variado','llaveros','Pulseras','Collares']);            
            $table->string('nombre');
            $table->integer('precio');
            $table->integer('cantidad');
            $table->string('descripcion');
            $table->binary('Imagen')->nullable(); // Cambiado a binary
            $table->Integer('rating')->default(0);
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('comprador_id');
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};

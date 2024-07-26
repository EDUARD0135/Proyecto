<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->text('motivo');
            $table->unsignedBigInteger('usuario_reporta_id')->nullable();
            $table->timestamps();
            
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('usuario_reporta_id')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reportes');
    }
};
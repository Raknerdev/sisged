<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimientos', function (Blueprint $table) {
            $table->id();
            
            $table->integer('id_documento');
            $table->integer('id_usuario');
            $table->string('accion');
            $table->date('fecha');
            $table->integer('bandeja_de');
            $table->string('instruccion');
            $table->string('estatus');
            $table->integer('tipo_c');
            // $table->string('seguimiento');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimientos');
    }
}

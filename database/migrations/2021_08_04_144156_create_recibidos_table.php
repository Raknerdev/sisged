<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecibidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibidos', function (Blueprint $table) {
            $table->id();

            $table->string('tipo');
            $table->uuid('uuid');
            $table->string('remitente');
            $table->string('estado')->nullable()->default('NO ESPECIFICADO');
            $table->string('otro');
            $table->string('recibido_por');
            $table->string('referencia');
            $table->string('file');
            $table->string('tipo_doc');
            $table->date('fecha_doc');
            $table->string('nro_doc');
            $table->string('estatus');
            $table->string('accion');
            $table->string('seguimiento');
            $table->integer('active')->nullable()->default(1);
            
            $table->string('bandeja_de');
            $table->string('codigo');
            $table->integer('tipo_c');
            
            // Extras
            $table->string('ref_doc')->nullable();
            $table->date('fecha_lim')->nullable();
            // $table->unsignedbIGinteger('id_user_destino');
            // $table->foreign('id_user_destino')->references('id')->on('users');

            $table->timestamps();
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_spanish_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recibidos');
    }
}

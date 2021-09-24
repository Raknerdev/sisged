<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnviadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enviados', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->date('fecha_doc');
            $table->string('referencia');
            $table->string('tipo');
            $table->string('destinatario');
            $table->string('estado')->nullable()->default('NO ESPECIFICADO');
            $table->string('otro');
            $table->string('estatus');
            $table->date('fecha_rec');
            $table->string('file');
            $table->string('nro_doc')->nullable()->default(0);
            $table->string('tipo_doc');
            $table->string('recibido_por');
            $table->string('accion');
            $table->string('bandeja_de');
            $table->string('seguimiento');
            $table->integer('active')->nullable()->default(1);

            $table->string('codigo');
            $table->integer('tipo_c');
            // Extras
            $table->string('ref_doc')->nullable();
            $table->date('fecha_lim')->nullable();
            $table->string('ccopia')->nullable();
          
            // $table->unsignedbIGinteger('id_user')->unsigned();
            // $table->foreign('id_user')->references('id')->on('users');
            // $table->unsignedbIGinteger('id_user_destino')->unsigned();
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
        Schema::dropIfExists('enviados');
    }
}

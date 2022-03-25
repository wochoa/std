<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafEspecificaDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_especifica_det', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('ano_eje', 4)->nullable();
            $table->integer('tipo_transaccion')->nullable();
            $table->integer('generica')->nullable();
            $table->integer('subgenerica')->nullable();
            $table->integer('subgenerica_det')->nullable();
            $table->integer('especifica')->nullable();
            $table->integer('especifica_det')->nullable();
            $table->string('id_clasificador', 7)->nullable();
            $table->string('descripcion', 250)->nullable();
            $table->string('ambito', 1)->nullable();
            $table->string('estado', 1)->nullable();
            $table->string('exclusivo_tp', 1)->nullable();

            //index
            $table->index([
                'ano_eje',
                'tipo_transaccion',
                'generica',
                'subgenerica',
                'subgenerica_det',
                'especifica',
                'especifica_det',
            ], 'siaf_especifica_det_indice');
            $table->index(['ano_eje', 'id_clasificador'], 'siaf_especifica_det_index2');
            $table->index([
                'ano_eje',
                'tipo_transaccion',
                'generica',
                'subgenerica',
                'subgenerica_det',
                'especifica',
                'especifica_det',
                'id_clasificador',
            ], 'siaf_especifica_det_indx3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_especifica_det');
    }
}

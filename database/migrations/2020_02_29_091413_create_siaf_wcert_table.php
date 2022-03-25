<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafWcertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_wcert', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('ano_eje', 4)->nullable();
            $table->string('sec_ejec', 6)->nullable();
            $table->string('sec_func', 4)->nullable();
            $table->string('act_proy', 7)->nullable();
            $table->string('certificado', 10)->nullable();
            $table->string('correlativo', 4)->nullable();
            $table->string('id_clasificador', 7)->nullable();
            $table->string('fuente_financ', 2)->nullable();
            $table->string('secuencia', 4)->nullable();
            $table->string('secuencia_padre', 4)->nullable();
            $table->string('estado_registro', 1)->nullable();
            $table->string('dispositivo_legal', 4)->nullable();
            $table->text('glosa')->nullable();
            $table->date('fecha_doc')->nullable();
            $table->string('num_doc')->nullable();
            $table->decimal('monto', 11, 2)->nullable();
            $table->decimal('comprometido', 11, 2)->nullable();
            $table->string('dispositivo', 4)->nullable();

            //index
            $table->index([
                'ano_eje',
                'sec_ejec',
                'act_proy',
                'sec_func',
                'certificado',
                'id_clasificador',
                'secuencia',
            ], 'siaf_wcert_indx1');
            $table->index([
                'ano_eje',
                'act_proy',
            ], 'siaf_wcert_indx2');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'act_proy',
                'sec_func',
                'fuente_financ',
                'id_clasificador',
            ], 'siaf_wcert_indx3');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
                'fuente_financ',
                'certificado',
                'id_clasificador',
                'secuencia',
                'correlativo',
            ], 'siaf_wcert_indx4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_wcert');
    }
}

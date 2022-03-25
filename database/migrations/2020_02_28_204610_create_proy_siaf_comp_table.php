<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProySiafCompTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_siaf_comp', function (Blueprint $table) {
            $table->string('ano_eje', 4)->nullable();
            $table->string('sec_ejec', 6)->nullable();
            $table->string('act_proy', 7)->nullable();
            $table->string('sec_func', 4)->nullable();
            $table->string('fuente_financ', 2)->nullable();
            $table->string('certificado', 10)->nullable();
            $table->string('secuencia', 4)->nullable();
            $table->string('secuencia_padre', 4)->nullable();
            $table->string('id_clasificador', 7)->nullable();
            $table->double('monto')->nullable();
            $table->string('cod_doc', 3)->nullable();
            $table->string('nombre', 250)->nullable();
            $table->string('num_doc', 50)->nullable();
            $table->string('glosa',255)->nullable();
            $table->date('fecha_doc')->nullable();
            $table->timestamps();

            //index
            $table->index(['ano_eje', 'act_proy'], 'proy_siaf_comp_indx1');
            $table->index([
                'ano_eje',
                'act_proy',
                'sec_func',
                'certificado',
                'secuencia',
                'secuencia_padre',
                'id_clasificador',
                'fecha_doc',
            ], 'proy_siaf_comp_indx2');
            $table->index(['ano_eje', 'act_proy', 'sec_func', 'id_clasificador'], 'proy_siaf_comp_indx3');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
                'fuente_financ',
                'certificado',
                'secuencia',
                'id_clasificador',
            ], 'proy_siaf_comp_indx4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_siaf_comp');
    }
}

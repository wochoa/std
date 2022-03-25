<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafWgastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_wgastos', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('ano_eje', 4)->nullable();
            $table->string('sec_ejec', 6)->nullable();
            $table->string('act_proy', 7)->nullable();
            $table->string('sec_func', 4)->nullable();
            $table->string('fuente_financ', 2)->nullable();
            $table->string('expediente', 10)->nullable();
            $table->string('ciclo', 1)->nullable();
            $table->string('fase', 1)->nullable();
            $table->string('secuencia', 4)->nullable();
            $table->string('certificado', 10)->nullable();
            $table->string('certificado_secuencia', 4)->nullable();
            $table->string('id_clasificador', 7)->nullable();
            $table->decimal('monto', 11, 2)->nullable();
            $table->string('ruc', 11)->nullable();
            $table->date('fecha_autorizacion')->nullable();
            $table->tinyInteger('mes')->nullable();
            $table->tinyInteger('dia')->nullable();
            $table->string('certificado_secuencia_padre', 4)->nullable();
            $table->text('notas')->nullable();
            $table->text('cps')->nullable();

            //index
            $table->index([
                'ano_eje',
                'act_proy',
            ], 'siaf_wgastos_indx1');
            $table->index([
                'ano_eje',
                'act_proy',
                'sec_func',
                'expediente',
                'secuencia',
                'id_clasificador',
                'certificado',
                'certificado_secuencia',
            ], 'siaf_wgastos_indx2');
            $table->index([
                'ano_eje',
                'act_proy',
                'sec_func',
                'fuente_financ',
                'id_clasificador',
            ], 'siaf_wgastos_indx3');
            $table->index([
                'ano_eje',
                'act_proy',
                'sec_func',
                'fuente_financ',
                'id_clasificador',
                'mes',
            ], 'siaf_wgastos_indx4');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'fecha_autorizacion',
            ], 'siaf_wgastos_indx5');
            $table->index([
                'ano_eje',
                'ciclo',
                'fase',
            ], 'siaf_wgastos_indx6');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_wgastos');
    }
}

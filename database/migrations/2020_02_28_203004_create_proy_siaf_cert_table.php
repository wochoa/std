<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProySiafCertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_siaf_cert', function (Blueprint $table) {
            $table->string('ano_eje', 4)->nullable();
            $table->string('sec_ejec', 6)->nullable();
            $table->string('sec_func', 4)->nullable();
            $table->string('act_proy', 7)->nullable();
            $table->string('certificado', 10)->nullable();
            $table->string('id_clasificador', 7)->nullable();
            $table->string('fuente_financ', 2)->nullable();
            $table->string('secuencia', 4)->nullable();
            $table->string('secuencia_padre', 4)->nullable();
            $table->string('estado_registro', 1)->nullable();
            $table->string('dispositivo_legal', 4)->nullable();
            $table->text('glosa')->nullable();
            $table->double('monto')->nullable();
            $table->double('comprometido')->nullable();
            $table->string('dispositivo', 4)->nullable();
            $table->timestamps();

            //index
            $table->index([
                'ano_eje',
                'sec_ejec',
                'act_proy',
                'sec_func',
                'certificado',
                'id_clasificador',
                'secuencia',
            ], 'proy_siaf_cert_indx1');
            $table->index(['ano_eje', 'act_proy'], 'proy_siaf_cert_indx2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_siaf_cert');
    }
}

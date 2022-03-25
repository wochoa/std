<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyPresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_presupuesto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proy_siaf_anio',4)->nullable();
            $table->string('proy_sec_ejec',6)->nullable();
            $table->string('proy_siaf_sec_func',4)->nullable();
            $table->integer('proy_tram_dependencia')->nullable();
            $table->integer('proy_user_id')->nullable();
            $table->timestamps();


            $table->index([
                'id',
                'proy_siaf_anio',
                'proy_sec_ejec',
                'proy_siaf_sec_func',
                'proy_tram_dependencia',
            ], 'proy_presupuesto_indx1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_presupuesto');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyEtapaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_etapa', function (Blueprint $table) {
            $table->increments('idetapa_etapa');
            $table->string('eta_descripcion', 50)->nullable();
            $table->integer('eta_plazo')->nullable();
            $table->string('eta_', 50)->nullable();
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
        Schema::dropIfExists('proy_etapa');
    }
}

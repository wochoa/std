<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramPrioridadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //tabla prioridad
        Schema::create('tram_prioridad', function (Blueprint $table) {
            $table->increments('idprioridad');
            $table->string('prio_descripcion', 20);
            $table->string('prio_abreviado', 10);
            $table->timestamps();
        });

        //tabla recepcion
        Schema::create('tram_recepcion', function (Blueprint $table) {
            $table->increments('idrecepcion');
            $table->string('rece_descripcion', 20);
            $table->string('rece_abreviado', 10);
            $table->timestamps();
        });

        //tabla documento main
        Schema::create('tram_documentomain', function (Blueprint $table) {
            $table->increments('iddocumentomain');
            $table->integer('dmai_idusu');
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
        Schema::dropIfExists('tram_prioridad');

        Schema::dropIfExists('tram_recepcion');

        Schema::dropIfExists('tram_documentomain');
    }
}

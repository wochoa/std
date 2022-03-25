<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyActividadObraRegulationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_actividad_obra_regulation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_regulation')->nullable();
            $table->integer('id_actividad_obra')->nullable();
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
        Schema::dropIfExists('proy_actividad_obra_regulation');
    }
}

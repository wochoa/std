<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafUnidadMedidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_unidad_medida', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('unidad_medida')->nullable();
            $table->string('nombre', 150)->nullable();
            $table->string('abreviatura', 15)->nullable();
            $table->string('ambito', 1)->nullable();
            $table->string('estado', 1)->nullable();
            $table->string('es_logistica', 1)->nullable();
            $table->string('es_presupuestal', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_unidad_medida');
    }
}

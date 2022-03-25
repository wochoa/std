<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafEspecificaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_especifica', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('ano_eje', 4)->nullable();
            $table->integer('tipo_transaccion')->nullable();
            $table->integer('generica')->nullable();
            $table->integer('subgenerica')->nullable();
            $table->integer('subgenerica_det')->nullable();
            $table->text('especifica')->nullable();
            $table->string('descripcion', 250)->nullable();
            $table->string('ambito', 1)->nullable();
            $table->string('estado', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_especifica');
    }
}

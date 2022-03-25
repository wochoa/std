<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafWgastosResumenTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('siaf_wgastos_resumen', function (Blueprint $table) {
      $table->engine = 'MyISAM';
      $table->string('ano_eje',4)->nullable();
      $table->string('sec_ejec',6)->nullable();
      $table->string('act_proy',7)->nullable();
      $table->string('sec_func',4)->nullable();
      $table->string('id_clasificador',7)->nullable();
      $table->string('ciclo',1)->nullable();
      $table->string('fase',1)->nullable();
      $table->decimal('monto',11,2)->nullable();
    });
  }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_wgastos_resumen');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafMetaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('siaf_meta', function (Blueprint $table) {
      $table->engine = 'MyISAM';
      $table->string('ano_eje', 4)->nullable();
      $table->string('sec_ejec', 6)->nullable();
      $table->string('sec_func', 4)->nullable();
      $table->string('funcion', 2)->nullable();
      $table->string('programa', 11)->nullable();
      $table->string('sub_programa', 4)->nullable();
      $table->string('act_proy', 7)->nullable();
      $table->string('componente', 7)->nullable();
      $table->string('meta', 5)->nullable();
      $table->string('finalidad', 7)->nullable();
      $table->string('nombre', 150)->nullable();
      $table->decimal('monto',11,2)->nullable();
      $table->string('cantidad',25)->nullable();
      $table->string('unidad_med', 5)->nullable();
      $table->string('programa_ppto', 4)->nullable();

            //index
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
                'act_proy',
            ], 'siaf_meta_indx1');
            $table->index('act_proy', 'siaf_meta_indx2');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'funcion',
                'programa',
                'sub_programa',
                'act_proy',
                'componente',
                'finalidad',
            ], 'siaf_meta_indx3');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
                'funcion',
                'programa',
                'sub_programa',
                'act_proy',
                'componente',
                'meta',
                'finalidad',
                'programa_ppto',
            ], 'siaf_meta_indx4');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
                'funcion',
                'programa',
                'sub_programa',
                'act_proy',
                'componente',
                'meta',
                'programa_ppto',
            ], 'siaf_meta_indx5');
        });
    }

    /**.
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_meta');
    }
}

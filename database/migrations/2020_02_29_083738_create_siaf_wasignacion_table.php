<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafWasignacionTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('siaf_wasignacion', function (Blueprint $table) {
      $table->engine = 'MyISAM';
      $table->string('ano_eje',4)->nullable();
      $table->string('sec_ejec',6)->nullable();
      $table->string('sec_nota',10)->nullable();
      $table->string('sec_func',4)->nullable();
      $table->string('fuente_financ',2)->nullable();
      $table->string('id_clasificador',7)->nullable();
      $table->double('monto_de',11,2)->nullable();
      $table->double('monto_a',11,2)->nullable();
      $table->text('notas')->nullable();
      $table->date('fecha')->nullable();
      $table->tinyInteger('mes')->nullable();

            //index
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
            ], 'siaf_wasignacion_indx1');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
                'fuente_financ',
                'id_clasificador',
            ], 'siaf_wasignacion_indx2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_wasignacion');
    }
}

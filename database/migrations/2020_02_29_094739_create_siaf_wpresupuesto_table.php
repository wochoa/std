<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafWpresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_wpresupuesto', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('ano_eje', 4)->nullable();
            $table->string('sec_ejec', 6)->nullable();
            $table->string('sec_func', 4)->nullable();
            $table->string('fuente_financ', 2)->nullable();
            $table->string('componente', 7)->nullable();
            $table->decimal('pia', 11, 0)->nullable();
            $table->string('id_clasificador', 7)->nullable();
            $table->string('act_proy', 7)->nullable();
            $table->string('nombre')->nullable();
            $table->decimal('modif', 11, 0)->nullable();
            $table->decimal('pim', 11, 0)->nullable();
            $table->decimal('monto_cert', 11, 2)->nullable();
            $table->text('certs')->nullable();
            $table->decimal('monto_comp_anual', 11, 2)->nullable();
            $table->decimal('monto_comp', 11, 2)->nullable();
            $table->decimal('monto_dev', 11, 2)->nullable();
            $table->decimal('g_1', 11, 2)->nullable();
            $table->decimal('g_2', 11, 2)->nullable();
            $table->decimal('g_3', 11, 2)->nullable();
            $table->decimal('g_4', 11, 2)->nullable();
            $table->decimal('g_5', 11, 2)->nullable();
            $table->decimal('g_6', 11, 2)->nullable();
            $table->decimal('g_7', 11, 2)->nullable();
            $table->decimal('g_8', 11, 2)->nullable();
            $table->decimal('g_9', 11, 2)->nullable();
            $table->decimal('g_10', 11, 2)->nullable();
            $table->decimal('g_11', 11, 2)->nullable();
            $table->decimal('g_12', 11, 2)->nullable();

            //index
            $table->index([
                'ano_eje',
                'act_proy',
            ], 'siaf_wpresupuesto_indx1');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
                'id_clasificador',
                'act_proy',
            ], 'siaf_wpresupuesto_indx2');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
                'fuente_financ',
                'id_clasificador',
            ], 'siaf_wpresupuesto_indx3');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
                'fuente_financ',
                'componente',
                'id_clasificador',
                'act_proy',
            ], 'siaf_wpresupuesto_indx4');
            $table->index([
                'ano_eje',
                'sec_ejec',
                'sec_func',
                'pim',
            ], 'siaf_wpresupuesto_indx5');
        });
    }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('siaf_wpresupuesto');
  }
}

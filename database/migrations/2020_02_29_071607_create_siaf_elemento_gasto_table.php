<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafElementoGastoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_elemento_gasto', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('ano_eje', 4)->nullable();
            $table->string('categ_gasto', 1)->nullable();
            $table->string('grupo_gasto', 1)->nullable();
            $table->string('modalidad_gasto', 2)->nullable();
            $table->string('elemento_gasto', 2)->nullable();
            $table->string('id_clasificador', 7)->nullable();//vacio en la otra BD tiene bastante registro
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_elemento_gasto');
    }
}

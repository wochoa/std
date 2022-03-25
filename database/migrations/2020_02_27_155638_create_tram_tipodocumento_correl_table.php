<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramTipodocumentoCorrelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_tipodocumento_correl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tdco_idtipodocumento')->unsigned();

            $table->integer('tdco_iddependencia')->unsigned();

            $table->integer('tdco_idusuario')->nullable();

            $table->integer('tdco_periodo');
            $table->integer('tdco_numero');
            $table->timestamps();

            //index
            $table->index('tdco_iddependencia', 'tram_tipodocumento_correl_tdco_iddependencia_foreign');
            $table->index('tdco_idtipodocumento', 'tram_tipodocumento_correl_tdco_idtipodocumento_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tram_tipodocumento_correl');
    }
}

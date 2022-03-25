<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafDispositivosLegalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_dispositivos_legales', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('ano_eje', 4)->nullable();
            $table->string('dispositivo_legal', 4)->nullable();
            $table->string('nombre', 150)->nullable();
            $table->string('descripcion', 250)->nullable();
            $table->string('prioridad', 4)->nullable();
            $table->string('referencia', 150)->nullable();
            $table->string('norma_referencia', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_dispositivos_legales');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyActividadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_actividad', function (Blueprint $table) {
            $table->increments('idactividad');
            $table->string('act_descripcion', 50)->nullable();
            $table->string('act_desc_corta', 10)->nullable();
            $table->integer('act_plazo_probable')->nullable();
            $table->integer('act_accion')->nullable()->default(0)->comment('0:nada\n1:paralizacion\n2:ampliacion\n3:adicional\n4:deductivo\n5: adelanto6: valorizacion');
            $table->unsignedInteger('etapa_idetapa_etapa');
            $table->foreign('etapa_idetapa_etapa')->references('idetapa_etapa')->on('proy_etapa');
            $table->timestamps();
            //index
            $table->index('etapa_idetapa_etapa', 'fk_actividades_etapa1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_actividad');
    }
}

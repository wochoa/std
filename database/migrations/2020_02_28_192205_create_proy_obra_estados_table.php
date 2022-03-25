<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyObraEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_obra_estados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion')->nullable();
            $table->integer('etapa')->nullable()->default(0)->comment('0 condiciones previas 1 ejecucion 2 culminada 3 entregada 4 liquidada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_obra_estados');
    }
}

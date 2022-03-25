<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyToolsModificatoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_tools_modificatoria', function (Blueprint $table) {
            $table->increments('id');
            $table->string('modif_anio', 4)->nullable();
            $table->string('modif_titulo')->nullable();
            $table->date('modif_fecha_aprovacion')->nullable();//redundante
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
        Schema::dropIfExists('proy_tools_modificatoria');
    }
}

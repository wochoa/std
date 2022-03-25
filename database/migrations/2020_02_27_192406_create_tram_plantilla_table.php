<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramPlantillaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_plantilla', function (Blueprint $table) {
            $table->increments('id');
            $table->string('plt_nombre', 200)->nullable();
            $table->text('plt_plantilla')->nullable();
            $table->text('plt_datos');
            $table->text('plt_derivaciones')->nullable();
            $table->text('plt_referencias')->nullable();
            $table->integer('plt_idadmin')->nullable();
            $table->integer('plt_iddependencia')->nullable();
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
        Schema::dropIfExists('tram_plantilla');
    }
}

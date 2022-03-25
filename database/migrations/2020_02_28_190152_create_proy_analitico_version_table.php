<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyAnaliticoVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_analitico_version', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vers_proyecto')->nullable();
            $table->integer('vers_version')->nullable();
            $table->integer('vers_responzable')->nullable();
            $table->string('vers_cargo', 255)->nullable();
            $table->text('vers_observacion')->nullable();
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
        Schema::dropIfExists('proy_analitico_version');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyPlanVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_plan_version', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vers_proyecto')->nullable();
            $table->integer('vers_version')->nullable();
            $table->integer('vers_anio')->nullable();
            $table->integer('vers_responzable')->nullable();
            $table->string('vers_cargo', 200)->nullable();
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
        Schema::dropIfExists('proy_plan_version');
    }
}

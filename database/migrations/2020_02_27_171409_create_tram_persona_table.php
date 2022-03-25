<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramPersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_persona', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('dni', 8);
            $table->string('apPrimer', 100)->nullable();
            $table->string('apSegundo', 100)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('estadoCivil', 100)->nullable();
            $table->text('foto')->nullable();
            $table->string('prenombres', 200)->nullable();
            $table->string('restriccion', 255)->nullable();
            $table->string('ubigeo', 255)->nullable();
            $table->primary('id');
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
        Schema::dropIfExists('tram_persona');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramPersonaCorreo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_persona_correo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('persona_dni', 8)->nullable();
            $table->string('persona_ruc', 11)->nullable();
            $table->string('correo');
            $table->string('codigo', 8)->nullable();
            $table->decimal('estado', 1, 0);
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
        Schema::dropIfExists('tram_persona_correo');
    }
}

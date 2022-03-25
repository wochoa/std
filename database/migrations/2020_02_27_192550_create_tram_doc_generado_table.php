<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramDocGeneradoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_doc_generado', function (Blueprint $table) {
            $table->increments('id');
            $table->text('dgen_html')->nullable();
            $table->text('dgen_datos');
            $table->text('dgen_derivaciones')->nullable();
            $table->text('dgen_referencias')->nullable();
            $table->integer('dgen_idadmin')->nullable();
            $table->integer('dgen_iddependencia')->nullable();
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
        Schema::dropIfExists('tram_doc_generado');
    }
}

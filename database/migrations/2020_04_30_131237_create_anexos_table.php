<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnexosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iotdtd_anexo', function (Blueprint $table) {
            $table->bigIncrements('siddocanx');
            $table->unsignedBigInteger('siddocext');//fornykey
            $table->string('vnomdoc', 100);
            $table->date('dfecreg')->default(now());
            $table->foreign('siddocext')->references('siddocext')->on('iotdtm_doc_externo');
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
        Schema::dropIfExists('iotdtd_anexo');
    }
}

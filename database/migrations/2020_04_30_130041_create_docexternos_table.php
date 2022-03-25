<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocexternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iotdtm_doc_externo', function (Blueprint $table) {
            $table->bigIncrements('siddocext');
            $table->string('vnomentemi', 250);
            $table->char('ccodtipdoc', 2);
            $table->string('vnumdoc', 100);
            $table->date('dfecdoc');
            $table->string('vuniorgdst', 150);
            $table->string('vnomdst', 100);
            $table->string('vnomcardst', 100);
            $table->string('vasu', 500);
            $table->char('cindtup', 1)->nullable()->default('N')->comment('INDICADOR DE TUPA S= SIN TUPA, C = CONTUPA');//no concuerda
            $table->tinyInteger('snumanx')->nullable()->default(0);
            $table->tinyInteger('snumfol')->default(0);
            $table->string('vurldocanx', 200)->nullable();
            $table->unsignedBigInteger('sidemiext')->nullable();//fornykey
            $table->unsignedBigInteger('sidrecext')->nullable();//fornykey

            $table->foreign('sidemiext')->references('sidemiext')->on('iotdtc_despacho');
            $table->foreign('sidrecext')->references('sidrecext')->on('iotdtc_recepcion');
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
        Schema::dropIfExists('iotdtm_doc_externo');
    }
}

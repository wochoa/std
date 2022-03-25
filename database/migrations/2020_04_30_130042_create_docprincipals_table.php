<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocprincipalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iotdtd_doc_principal', function (Blueprint $table) {
            $table->bigIncrements('siddocpri');
            $table->unsignedBigInteger('siddocext');//fornykey
            $table->string('vnomdoc', 200);
            $table->binary('bpdfdoc');
            //$table->char('ccodest', 1)->default('1')->comment('ESTADO DEL REGISTRO 1 = ACTIVO, 0 = INACTIVO');//no concuerda en el manual esta 1 y 0
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
        Schema::dropIfExists('iotdtd_doc_principal');
    }
}

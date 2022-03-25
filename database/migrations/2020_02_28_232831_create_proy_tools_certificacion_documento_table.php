<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyToolsCertificacionDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_tools_certificacion_documento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_documento')->nullable();
            $table->date('doc_fecha')->nullable();
            $table->string('doc_oficina')->nullable();
            $table->integer('doc_reg_sisgedo')->nullable();
            $table->integer('doc_exp_sisgedo')->nullable();
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
        Schema::dropIfExists('proy_tools_certificacion_documento');
    }
}

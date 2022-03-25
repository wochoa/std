<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyToolsCertificarDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_tools_certificar_det', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitud_id')->nullable();
            $table->string('det_secuencia', 12)->nullable();
            $table->string('det_correlativ', 12)->nullable();
            $table->string('det_anio', 4)->nullable();
            $table->string('det_sec_func', 4)->nullable();
            $table->string('det_fuente_financiamiento', 2)->nullable();
            $table->char('det_id_clasif')->nullable();
            $table->decimal('det_pia', 11, 2)->nullable();
            $table->decimal('det_pim', 11, 2)->nullable();
            $table->decimal('det_monto_solicitado', 11, 2)->nullable();
            $table->decimal('det_certificacion', 11, 2)->nullable();

            $table->foreign('solicitud_id')->references('id')->on('proy_tools_certificacion')->onDelete('cascade');

            $table->timestamps();
            //index
            $table->index('solicitud_id', 'fk_solicitud');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_tools_certificar_det');
    }
}

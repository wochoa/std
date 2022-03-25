<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyToolsCertificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_tools_certificacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('solc_certificado', 10)->nullable();
            $table->string('solc_oficina')->nullable();
            $table->date('solc_fecha')->nullable();
            $table->string('solc_documento')->nullable();
            $table->integer('documento_id')->nullable();
            $table->integer('solc_doc_sisgedo')->nullable();
            $table->integer('solc_tipo_gasto')->nullable();
            $table->text('solc_objeto')->nullable();
            $table->string('solc_tipo_proceso_seleccion', 256)->nullable();
            $table->string('solc_otros', 256)->nullable();
            $table->string('solc_justificacion', 256)->nullable();
            $table->string('solc_doc_priorizacion')->nullable();
            $table->decimal('solc_pia', 11, 2)->nullable();
            $table->decimal('solc_pim', 11, 2)->nullable();
            $table->decimal('solc_certificacion', 11, 2)->nullable();
            $table->decimal('solc_monto_solicitado', 11, 2)->nullable();
            $table->integer('solc_anio')->nullable();
            $table->integer('solc_act_proy')->nullable();
            $table->integer('solc_sec_func')->nullable();
            $table->integer('solc_fuente_financiamiento')->nullable();
            $table->char('solc_id_clasif', 7)->nullable();
            $table->integer('usuario_id')->nullable();
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
        Schema::dropIfExists('proy_tools_certificacion');
    }
}

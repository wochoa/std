<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramDocumentoExterno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_documento_externo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('iddocumento')->nullable();
            $table->integer('docu_idexma')->nullable();
            $table->integer('docu_iddependencia')->unsigned();
            $table->integer('id_dependencia')->unsigned();
            $table->string('docu_detalle', 60)->nullable();
            $table->string('docu_firma', 60);
            $table->string('docu_cargo', 70)->nullable();
            $table->integer('docu_idtipodocumento')->unsigned();

            $table->date('docu_fecha_doc');
            $table->integer('docu_numero_doc')->nullable()->unsigned();
            $table->string('docu_siglas_doc', 65)->nullable();
            $table->integer('docu_folios')->nullable();
            $table->string('docu_asunto', 1001)->nullable();

            $table->string('docu_emailorigen', 80)->nullable();
            $table->integer('docu_estado')->comment('0: Espera a ser aceptada, 1: Archivado, 2: Derivado, 3: Subsanado');
            $table->string('docu_motivo_archivamiento', 1000)->nullable();
            $table->string('docu_idtdoc', 1)->nullable();
            $table->string('docu_numtdoc', 15)->nullable();//expo_numtdoc
            $table->string('docu_domic', 150)->nullable();
            $table->string('docu_dni', 8)->nullable();
            $table->string('docu_ruc', 11)->nullable();
            $table->string('docu_telef', 15)->nullable();
            $table->decimal('docu_firma_electronica', 1, 0)->nullable();
            $table->string('docu_token', 50)->nullable();
            $table->integer('updated_by')->unsigned()->nullable();

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
        Schema::dropIfExists('tram_documento_externo');
    }
}

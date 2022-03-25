<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_documento', function (Blueprint $table) {
            $table->increments('iddocumento');
            $table->decimal('docu_origen',1 ,0);//expe_orige interno, externo; numeric in postgres
            $table->integer('docu_tipo')->nullable();//numeric in postgres
            $table->integer('docu_idprioridad');
            $table->decimal('docu_forma', 1, 0);
            $table->decimal('docu_digital', 1, 0)->default(0);
            $table->integer('docu_iddependencia')->unsigned();

            $table->string('docu_ruc', 11)->nullable();
            $table->string('docu_detalle', 60)->nullable();
            $table->string('docu_firma', 60);
            $table->string('docu_cargo', 70)->nullable();
            $table->integer('docu_idtipodocumento')->unsigned();

            $table->date('docu_fecha_doc');
            $table->integer('docu_numero_doc')->nullable()->unsigned();
            $table->string('docu_siglas_doc', 65)->nullable();
            $table->string('docu_proyectado', 10)->nullable();
            $table->integer('docu_idrecepcion');
            $table->integer('docu_folios')->nullable();
            $table->string('docu_asunto', 1001)->nullable();
            $table->integer('docu_relacionado')->nullable();
            $table->integer('docu_idusuario')->unsigned();

            $table->integer('docu_idusuariodependencia');//es un atributo de la tabla dependencia (id_usu)
            $table->string('docu_emailorigen', 80)->nullable();
            $table->text('docu_archivo')->nullable();
            $table->integer('docu_estado');
            $table->decimal('docu_clastupa', 1, 0);
            $table->integer('docu_diasatencion')->nullable();
            $table->string('docu_idtdoc', 1)->nullable();
            $table->string('docu_numtdoc', 15)->nullable();//expo_numtdoc
            $table->integer('docu_idtupa')->nullable();
            $table->integer('docu_idexma')->nullable();
            $table->string('docu_domic', 150)->nullable();
            $table->string('docu_dni', 8)->nullable();
            $table->string('docu_telef', 15)->nullable();
            $table->integer('docu_doc_generado')->nullable();
            $table->decimal('docu_firma_electronica', 1, 0)->nullable();
            $table->string('docu_contrasenia', 8)->nullable();
            $table->string('docu_token', 50)->nullable();
            $table->text('docu_referencias')->nullable();

            $table->timestamps();

            //index
            //$table->index(['docu_detalle', 'docu_firma', 'docu_siglas_doc', 'docu_asunto', 'docu_dni'],'tram_documento_docu_filter');//USING gin
            $table->index('docu_iddependencia', 'tram_documento_docu_iddependencia_foreign');
            $table->index('docu_idexma', 'tram_documento_docu_idexma');
            $table->index('docu_idtipodocumento', 'tram_documento_docu_idtipodocumento_foreign');
            $table->index(['iddocumento', 'docu_iddependencia', 'docu_idtipodocumento'], 'tram_operacion_iddocumento');
            $table->index(['iddocumento', 'docu_idtipodocumento'], 'tram_operacion_indx1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tram_documento');
    }
}

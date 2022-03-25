<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramOperacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_operacion', function (Blueprint $table) {
            $table->increments('idoperacion');
            $table->integer('oper_iddocumento')->unsigned();//llave foranea de documento(iddocumento)
            $table->integer('oper_iddependencia')->unsigned();//llave foranea de dependencia(iddependencia)

            $table->integer('oper_idusuario')->unsigned();//llave foranea de usuario(idusuario)

            $table->integer('oper_idarchivador')->nullable()->unsigned();//llave foranea de archivador(idarchivador)
            $table->decimal('oper_idtope', 1, 0)->nullable()->unsigned();
            $table->decimal('oper_es_destino', 1, 0)->nullable()->unsigned()->default(1);
            $table->decimal('oper_manual', 1, 0)->nullable()->unsigned()->default(0);
            $table->integer('oper_forma')->unsigned();
            $table->integer('oper_depeid_d')->nullable()->unsigned();
            $table->integer('oper_usuid_d')->nullable()->unsigned();
            $table->string('oper_detalledestino', 150)->nullable();
            $table->string('oper_persona', 150)->nullable();
            $table->string('oper_cargo', 150)->nullable();
            $table->string('oper_acciones', 500)->nullable();
            $table->integer('oper_idprocesado')->nullable()->unsigned();
            $table->integer('oper_iddocumento_adj')->nullable()->unsigned();
            $table->integer('oper_procesado')->nullable()->unsigned();
            $table->string('oper_tarchi_id')->nullable();

            $table->timestamps();

            //index
            $table->index(['oper_iddependencia', 'oper_idtope', 'oper_procesado'], 'tram_operacion_en_proceso');
            $table->index('idoperacion', 'tram_operacion_id');//USING hash
            $table->index('oper_iddocumento_adj', 'tram_operacion_id_adjuntado');//USING hash
            $table->index('oper_idprocesado', 'tram_operacion_id_procesado'); //USING hash
            $table->index(['oper_iddependencia', 'oper_idusuario', 'oper_idtope'], 'tram_operacion_indx_archivados');
            $table->index('oper_iddocumento', 'tram_operacion_indx_buscar_do');
            $table->index([
                'oper_idusuario',
                'oper_idtope',
                'oper_depeid_d',
                'oper_procesado',
            ], 'tram_operacion_indx_por_recibir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tram_operacion');
    }
}

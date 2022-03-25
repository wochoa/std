<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramDependenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_dependencia', function (Blueprint $table) {
            $table->increments('iddependencia');
            $table->string('depe_nombre', 80)->nullable();
            $table->string('depe_abreviado', 30)->nullable();
            $table->string('depe_sigla', 40)->nullable();
            $table->string('depe_representante', 60)->nullable();
            $table->string('depe_cargo', 30)->nullable();
            $table->string('depe_dni', 8)->nullable();
            $table->integer('depe_depende')->nullable();
            $table->string('depe_superior', 160)->nullable();
            $table->integer('depe_tipo');
            $table->integer('depe_proyectado');
            $table->integer('depe_estado')->nullable();
            $table->string('depe_observaciones', 100)->nullable();
            $table->integer('depe_idusuario')->nullable();
            $table->integer('depe_idusuariotransp')->nullable();
            $table->integer('depe_recibetramite')->nullable();
            $table->integer('depe_mesa_virtual')->default(0)->nullable();
            $table->integer('depe_agente')->nullable();
            $table->integer('depe_diasmaxenproceso')->nullable();
            $table->integer('depe_idusuarioreclamo')->nullable();
            $table->string('depe_imagen_header', 200)->nullable();
            $table->string('depe_imagen_footer', 200)->nullable();
            $table->integer('depe_rrhh')->nullable();
            $table->string('depe_ciudad', 150)->nullable();
            $table->integer('depe_minuto_tolerancia')->nullable();
            $table->timestamps();

            $table->index('iddependencia', 'tram_dependencia_indx1');
            $table->index(['iddependencia', 'depe_depende'], 'tram_dependencia_indx2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tram_dependencia');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_proyecto', function (Blueprint $table) {
            $table->increments('idproy_proyecto');
            $table->integer('proy_estado')->nullable();
            $table->string('proy_nombre', 250)->nullable();
            $table->string('proy_cod_snip', 10)->nullable();
            $table->string('proy_cod_siaf', 7)->nullable();
            $table->integer('funcion_id')->nullable();
            $table->string('proy_funcion', 50)->nullable();
            $table->integer('proy_beneficiarios')->nullable();
            $table->integer('ubigeo_id')->nullable();
            $table->string('proy_localidad', 50)->nullable();
            $table->decimal('proy_pip_actualizado', 11, 2)->nullable();
            $table->decimal('proy_perfil_viable', 11, 2)->nullable();
            $table->decimal('proy_snip15', 11, 2)->nullable();
            $table->decimal('proy_snip16', 11, 2)->nullable();
            $table->string('proy_verificacion_viabilidad', 50)->nullable();
            $table->string('proy_modificaciones_sin_evaluacion', 50)->nullable();
            $table->date('proy_fech_registro_perfil')->nullable();
            $table->date('proy_fecha_exp_tec')->nullable();
            $table->integer('admin_administrador')->nullable();
            $table->text('proy_ejecucion_anual')->nullable();
            $table->string('proy_tipo_proyecto', 11)->nullable()->comment('1: administracion directa\n2: contrato\n3: estudio\n4: otros');
            $table->string('proy_fte_fto', 50)->nullable();
            $table->text('proy_pim')->nullable();
            $table->dateTime('proy_act_sosem')->nullable();//innecesario
            $table->decimal('proy_ejecucion_otras_ejecutoras', 11, 2)->nullable();
            $table->dateTime('proy_act_ejecucion')->nullable();
            $table->timestamps();

            //index
            $table->index('ubigeo_id', 'fk_proy_proyecto_distrito1_idx');
            $table->index('admin_administrador', 'fk_proy_proyecto_admin1_idx');
            $table->index(['proy_cod_siaf', 'proy_cod_snip'], 'proy_proyecto_indx1');
            $table->index('proy_cod_siaf', 'proy_proyecto_indx2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_proyecto');
    }
}

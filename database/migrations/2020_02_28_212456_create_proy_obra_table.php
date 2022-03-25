<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyObraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_obra', function (Blueprint $table) {
            $table->increments('idobra');
            $table->unsignedInteger('proy_proyecto_idproy_proyecto')->nullable();
            $table->integer('obr_vinculo')->nullable();
            $table->integer('obr_estado')->nullable()->comment('0: condiciones previas: 1\n1: en ejecucion: 2\n2: en liquidacion: 5\n3: paralizado: 3\n4: Finalizado: 6\n5: por recepcionar: 4\n6: en estudio\n7: otros');
            $table->text('obr_componentes_metas')->nullable();
            $table->text('obr_descripcion_estado')->nullable();
            $table->text('obr_nombre')->nullable();
            $table->integer('obr_beneficiarios')->nullable();
            $table->integer('distrito_dis_codigo')->nullable();
            $table->string('obr_tipo_proceso', 250)->nullable();
            $table->string('obr_proceso_seleccion', 50)->nullable();
            $table->decimal('obr_valor_referencial', 11, 2)->nullable();
            $table->string('obr_modalidad_ejecucion', 50)->nullable()->comment('1: administracion directa\n2: contrato\n3: estudio\n4: otros');
            $table->decimal('obr_monto_contrato', 11, 2)->nullable();
            $table->decimal('obr_monto_exp_tec', 11, 2)->nullable()->comment('monto expediente tecnico');
            $table->string('obr_numero_contrato', 50)->nullable();
            $table->date('obr_fecha_contrato')->nullable();
            $table->integer('obr_plazo')->nullable();
            $table->date('obr_fecha_inicio_ejecucion')->nullable();
            $table->string('obr_fte_fto', 50)->nullable();
            $table->string('obr_otros', 50)->nullable();
            $table->string('obr_contrato_ejecucion', 50)->nullable();
            $table->string('obr_direccion_ejecutor', 200)->nullable();
            $table->string('obr_residente_nombre', 50)->nullable();
            $table->string('obr_residente_correo', 50)->nullable();
            $table->string('obr_residente_direccion', 150)->nullable();
            $table->string('obr_residente_celular', 10)->nullable();
            $table->string('obr_monitor_nombre', 50)->nullable();
            $table->string('obr_monitor_correo', 50)->nullable();
            $table->string('obr_monitor_direccion', 150)->nullable();
            $table->string('obr_monitor_celular', 150)->nullable();
            $table->string('obr_image', 250)->nullable();
            $table->date('obr_fecha_exp_tec')->nullable();
            $table->date('obr_fecha_reg_perfil')->nullable();
            $table->integer('obr_car_fia_fiel_cumplimiento_requiere')->nullable();
            $table->integer('obr_car_fia_adelanto_directo_requiere')->nullable();
            $table->integer('obr_car_fia_adelanto_material_requiere')->nullable();
            $table->string('obr_nombre_ejecutor', 200)->nullable();
            $table->string('obr_representante_ejecutor', 200)->nullable();
            $table->text('obr_ejecutor_empresas')->nullable();
            $table->decimal('obr_fr', 10, 5)->nullable();
            $table->integer('monitor_idadmin')->nullable();
            $table->decimal('obr_val_acumulada', 11, 2)->nullable();
            $table->decimal('obr_monto_contatado', 11, 2)->nullable();
            $table->integer('regulation_idregulation')->nullable();
            $table->integer('obr_vigente')->nullable()->default(1);
            $table->integer('obr_tipo_contrato')->nullable()->default(2)->comment('1:expediente tecnico\n2:ejecucion\n3:supervicion\r\n4:otros');
            $table->char('obr_contratista_ruc', 11)->nullable();
            $table->integer('obr_contrato_principal')->nullable()->default(0)->comment('0:false\r\n1:true');

            $table->foreign('proy_proyecto_idproy_proyecto')->references('idproy_proyecto')->on('proy_proyecto');

            $table->timestamps();
            //index
            $table->index('distrito_dis_codigo', 'fk_obra_distrito1_idx');
            $table->index('obr_estado', 'proy_obra_estado');
            $table->index('monitor_idadmin', 'fk_proy_obra_admin1_idx');
            $table->index('proy_proyecto_idproy_proyecto', 'fk_proy_obra_proy_proyecto1_idx');
            $table->index('regulation_idregulation', 'fk_proy_obra_regulation1_idx');
            $table->index(['idobra', 'obr_vigente', 'proy_proyecto_idproy_proyecto'], 'proy_obra_indx1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_obra');
    }
}

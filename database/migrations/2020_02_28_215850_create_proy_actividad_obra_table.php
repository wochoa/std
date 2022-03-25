<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyActividadObraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_actividad_obra', function (Blueprint $table) {
            $table->increments('idactividades');
            $table->text('aco_observacion')->nullable();
            $table->date('aco_ocurrencia')->nullable();
            $table->integer('aco_demora')->nullable();
            $table->date('aco_inicio')->nullable();
            $table->date('aco_programado')->nullable();
            $table->date('aco_ideal')->nullable();
            $table->integer('aco_orden')->nullable();
            $table->integer('aco_numero')->nullable();
            $table->unsignedInteger('actividad_idactividad')->nullable();
            $table->unsignedInteger('obra_idobra')->nullable();
            $table->integer('aco_vinculo')->nullable()->default(0)->comment('0:contractual, else numero de adicional');
            $table->integer('aco_accion')->nullable()->default(0)->comment('0 : NINGUNO\n1: PARALIZACION\n2: AMPLIACION\n3: ADICIONAL\n4: DEDUCTIVO\n5: ADELANTO');
            $table->decimal('aco_accion_numero', 11, 2)->nullable()->default(0.00);
            $table->decimal('aco_avance_financiero', 11, 2)->nullable();
            $table->decimal('aco_avance_val', 11, 2)->nullable();
            $table->decimal('aco_avance_fisico', 6, 2)->nullable();
            $table->decimal('aco_meta_fisico', 11, 2)->nullable();
            $table->decimal('aco_meta_financiero', 11, 2)->nullable();
            $table->decimal('aco_saldo_amortizado', 11, 2)->nullable();
            $table->decimal('aco_girado', 11, 2)->nullable();
            $table->integer('aco_creado')->nullable()->default(1)->comment('0 : manual\n1 : automatico');
            $table->string('aco_uso_de_pruebas', 50)->nullable();
            $table->decimal('aco_amor_ad', 10, 2)->nullable();
            $table->decimal('aco_amor_am', 10, 2)->nullable();
            $table->decimal('aco_amor_reajuste', 10, 2)->nullable();
            $table->decimal('aco_amor_deduc', 10, 2)->nullable();
            $table->string('aco_amor_deduc_det', 255)->nullable();
            $table->decimal('aco_amor_reten', 10, 2)->nullable();
            $table->decimal('aco_amor_otros', 10, 2)->nullable();
            $table->string('aco_doc_supervisor', 100)->nullable();
            $table->date('aco_doc_supervisor_fecha')->nullable();
            $table->integer('aco_doc_supervisor_reg_sisgedo')->nullable();
            $table->text('aco_doc_emitido')->nullable();
            $table->integer('aco_doc_emitido_sisgedo')->nullable();
            $table->integer('aco_doc_emitido_sisgedo_expe')->nullable();
            $table->integer('aco_doc_emitido_sisgedo_num_doc')->nullable();
            $table->integer('aco_doc_emitido_generado')->nullable()->default(0);
            $table->integer('aco_doc_imprimir_acumulados')->nullable()->default(1);

            $table->foreign('actividad_idactividad')->references('idactividad')->on('proy_actividad');
            $table->foreign('obra_idobra')->references('idobra')->on('proy_obra');

            $table->timestamps();
            //index
            $table->index('actividad_idactividad', 'fk_actividad_obra_actividad1_idx');
            $table->index('obra_idobra', 'fk_actividad_obra_obra1_idx');
            $table->index(['actividad_idactividad', 'obra_idobra'], 'proy_actividad_obra_ind1');
            $table->index(['obra_idobra', 'aco_accion'], 'proy_actividad_obra_ind2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_actividad_obra');
    }
}

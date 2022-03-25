<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyToolsModificatoriaDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_tools_modificatoria_det', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('modificatoria_id')->unsigned();
            $table->integer('componente_id')->unsigned();
            $table->char('det_fuente_financiamiento', 2);
            $table->char('det_id_clasif', 7);
            $table->decimal('det_acumulado_proy', 11, 2)->nullable()->default(0.00);
            $table->decimal('det_acumulado_comp', 11, 2)->nullable()->default(0.00);
            $table->decimal('det_acumulado', 11, 2)->nullable()->nullable();
            $table->decimal('det_pim_proy', 11, 2)->nullable()->default(0.00);
            $table->decimal('det_pim_componente', 11, 2)->nullable()->default(0.00);
            $table->decimal('det_pim', 11, 2)->nullable()->default(0.00);
            $table->decimal('det_de', 11, 2)->nullable()->default(0.00);
            $table->decimal('det_a', 11, 2)->nullable()->default(0.00);
            $table->decimal('det_nuevo_pim', 11, 2)->nullable()->default(0.00);
            $table->string('det_justificacion', 255)->nullable();

            //$table->foreign('componente_id')->references('id')->on('proy_plan_componente');
            $table->foreign('modificatoria_id')->references('id')->on('proy_tools_modificatoria');

            $table->timestamps();
            //index
            $table->index([
                'modificatoria_id',
                'componente_id',
                'det_fuente_financiamiento',
                'det_id_clasif',
            ], 'modificatoria_detalle');
            $table->index('componente_id', 'fk_componente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_tools_modificatoria_det');
    }
}

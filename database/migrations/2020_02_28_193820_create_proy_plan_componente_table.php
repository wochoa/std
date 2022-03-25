<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyPlanComponenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_plan_componente', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comp_programa', 4)->nullable();
            $table->string('comp_prod_proy', 7)->nullable();
            $table->string('comp_act_al_obra', 7)->nullable();
            $table->string('comp_funcion', 2)->nullable();
            $table->string('comp_division_funcional', 11)->nullable();
            $table->string('comp_grupo_funcional', 4)->nullable();
            $table->string('comp_meta', 5)->nullable();
            $table->string('comp_finalidad', 7)->nullable();
            $table->string('comp_nombre', 150)->nullable();
            $table->decimal('comp_monto', 11, 2)->nullable();
            $table->decimal('comp_acumulado', 11, 2)->nullable();
            $table->timestamps();

            //index
            $table->index(['comp_programa','comp_prod_proy','comp_act_al_obra','comp_funcion','comp_division_funcional','comp_grupo_funcional','comp_finalidad','comp_meta'],'proy_plan_componente_indx1');
            $table->index(['comp_programa','comp_prod_proy','comp_act_al_obra','comp_funcion','comp_division_funcional','comp_grupo_funcional','comp_meta'],'proy_plan_componente_indx2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_plan_componente');
    }
}

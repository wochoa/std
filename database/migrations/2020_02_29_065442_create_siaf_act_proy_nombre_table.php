<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafActProyNombreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_act_proy_nombre', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('ano_eje', 4)->nullable();
            $table->string('act_proy', 7)->nullable();
            $table->string('tipo_act_proy', 1)->nullable();
            $table->string('nombre', 500)->nullable();

            $table->index(['ano_eje', 'act_proy'], 'siaf_act_proy_nombre_ind1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_act_proy_nombre');
    }
}

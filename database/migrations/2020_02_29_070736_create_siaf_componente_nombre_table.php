<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafComponenteNombreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_componente_nombre', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('ano_eje', 4)->nullable();
            $table->string('componente', 7)->nullable();
            $table->string('tipo_componente', 1)->nullable();
            $table->string('nombre', 250)->nullable();

            $table->index(['ano_eje', 'componente', 'tipo_componente'], 'siaf_componente_nombre_index1');
            $table->index(['componente', 'tipo_componente'], 'siaf_componente_nombre_indx2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_componente_nombre');
    }
}

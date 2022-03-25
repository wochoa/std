<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramPersonaJuridica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_persona_juridica', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_dep', 2)->nullable();
            $table->string('cod_dist', 6)->nullable();
            $table->string('cod_prov', 4)->nullable();
            $table->string('ddp_ciiu', 6)->nullable();
            $table->string('ddp_doble')->nullable();
            $table->string('ddp_estado', 2)->nullable();
            $table->string('ddp_fecact', 10)->nullable();
            $table->string('ddp_fecalt', 10)->nullable();
            $table->string('ddp_fecbaj', 10)->nullable();
            $table->string('ddp_flag22', 2)->nullable();
            $table->string('ddp_identi', 2)->nullable();
            $table->string('ddp_inter1', 2)->nullable();
            $table->string('ddp_lllttt')->nullable();
            $table->string('ddp_mclase')->nullable();
            $table->string('ddp_nombre');
            $table->string('ddp_nomvia')->nullable();
            $table->string('ddp_nomzon')->nullable();
            $table->string('ddp_numer1')->nullable();
            $table->string('ddp_numreg')->nullable()    ;
            $table->string('ddp_numruc')->unique();
            $table->string('ddp_reacti')->nullable();
            $table->string('ddp_refer1')->nullable();
            $table->string('ddp_secuen', 2)->nullable();
            $table->string('ddp_tamano', 2)->nullable();
            $table->string('ddp_tipvia', 2)->nullable();
            $table->string('ddp_tipzon', 2)->nullable();
            $table->string('ddp_tpoemp', 2)->nullable();
            $table->string('ddp_ubigeo', 6)->nullable();
            $table->string('ddp_userna')->nullable();
            $table->string('desc_ciiu')->nullable();
            $table->string('desc_dep')->nullable();
            $table->string('desc_dist')->nullable();
            $table->string('desc_estado')->nullable();
            $table->string('desc_flag22')->nullable();
            $table->string('desc_identi')->nullable();
            $table->string('desc_numreg')->nullable();
            $table->string('desc_prov')->nullable();
            $table->string('desc_tamano')->nullable();
            $table->string('desc_tipvia')->nullable();
            $table->string('desc_tipzon')->nullable();
            $table->string('desc_tpoemp')->nullable();
            $table->string('esActivo')->nullable();
            $table->string('esHabido')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tram_persona_juridica');
    }
}

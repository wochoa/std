<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramArchivadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_archivador', function (Blueprint $table) {
            $table->increments('idarch');
            $table->integer('arch_iddependencia')->unsigned();
            $table->integer('arch_idusuario');
            $table->string('arch_nombre', 60);
            $table->integer('arch_periodo');
            $table->integer('arch_idusuarioa')->nullable();
            $table->decimal('arch_papeleta', 1, 0)->nullable();
            $table->timestamps();

            $table->index('arch_iddependencia', 'tram_archivador_arch_iddependencia_foreign');
            $table->index('idarch', 'tram_archivador_idarch');
            $table->index(['idarch', 'arch_nombre'], 'tram_archivador_idarch_arch_nombre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tram_archivador');
    }
}

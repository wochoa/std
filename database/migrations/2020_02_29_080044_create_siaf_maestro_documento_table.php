<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafMaestroDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_maestro_documento', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('cod_doc', 3)->nullable();
            $table->string('nombre', 150)->nullable();
            $table->string('abreviatura', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_maestro_documento');
    }
}

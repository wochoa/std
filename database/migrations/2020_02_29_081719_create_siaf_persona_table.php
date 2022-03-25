<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafPersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_persona', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('tipo_id', 1)->nullable();
            $table->string('ruc', 11)->nullable();
            $table->string('nombre', 150)->nullable();
            //index
            $table->index([
                'tipo_id',
                'ruc',
            ], 'siaf_persona_indx1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_persona');
    }
}

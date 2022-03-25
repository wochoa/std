<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiafFuenteFinancTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaf_fuente_financ', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->string('ano_eje', 4)->nullable();
            $table->string('origen', 1)->nullable();
            $table->string('fuente_financ', 2)->nullable();
            $table->string('nombre', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siaf_fuente_financ');
    }
}

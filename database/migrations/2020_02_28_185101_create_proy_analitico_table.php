<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyAnaliticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_analitico', function (Blueprint $table) {
            $table->increments('analitico_id');
            $table->integer('ana_act_proy')->nullable()->unsigned();
            $table->integer('ana_componente')->nullable()->unsigned();
            $table->char('ana_especifca', 7)->nullable();
            $table->decimal('ana_monto', 11, 2)->nullable();
            $table->decimal('ana_modificaciones', 11, 2)->nullable();
            $table->string('ana_descricion', 150)->nullable();
            $table->integer('analitico_version_id')->nullable()->default(1)->comment('0:Borrador');
            $table->timestamps();

            //index
            $table->index(['ana_act_proy', 'ana_componente', 'ana_especifca', 'analitico_version_id'], 'inxd1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_analitico');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyInformeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_informe', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_proyecto')->nullable();
            $table->string('inf_descripcion', 255)->nullable();
            $table->integer('id_admin')->nullable();
            $table->string('inf_cordenadas', 200)->nullable();
            $table->decimal('inf_estado', 1, 0)->nullable();
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
        Schema::dropIfExists('proy_informe');
    }
}

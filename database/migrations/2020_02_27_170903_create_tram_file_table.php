<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTramFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tram_file', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_url', 200);
            $table->string('file_name', 255)->nullable();
            $table->string('file_tipo', 100)->nullable();
            $table->string('file_size', 100)->nullable();
            $table->decimal('file_mostrar', 1, 0)->nullable();
            $table->decimal('file_principal', 1, 0)->nullable();
            $table->string('file_html', 200)->nullable();
            $table->decimal('file_generado', 1,0)->nullable();
            $table->integer('id_documento')->nullable();
            $table->integer('id_documento_externo')->nullable();
            $table->integer('id_proy_informe')->nullable();
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
        Schema::dropIfExists('tram_file');
    }
}

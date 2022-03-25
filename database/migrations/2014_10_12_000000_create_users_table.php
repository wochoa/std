<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('adm_name', 70)->nullable();
            $table->string('adm_lastname', 191)->nullable();
            $table->string('adm_inicial', 191)->nullable();
            $table->string('adm_email', 191)->nullable();
            $table->string('adm_password', 191)->nullable();
            $table->integer('adm_estado')->nullable();
            $table->string('adm_cargo', 70)->nullable();
            $table->string('adm_correo', 191)->nullable();
            $table->integer('depe_id')->nullable();
            $table->date('adm_vigencia')->nullable();
            $table->string('adm_observacion', 191)->nullable();
            $table->integer('adm_tipo')->nullable();
            $table->integer('adm_caseta')->nullable();
            $table->integer('adm_esjefe')->nullable();
            $table->string('adm_correo_personal', 50)->nullable();
            $table->string('adm_telefono', 15)->nullable();
            $table->string('adm_direccion', 50)->nullable();
            $table->string('adm_dni', 8)->nullable();
            $table->string('adm_con_especialidad', 191)->nullable();
            $table->string('push_id', 500)->nullable();
            $table->decimal('adm_primer_logeo', 1, 0)->nullable();
            $table->rememberToken()->nullable();

            //index
            $table->index('id', 'indx1');

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
        Schema::drop('admin');
    }
}

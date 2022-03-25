<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecepcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iotdtc_recepcion', function (Blueprint $table) {
            $table->bigIncrements('sidrecext');
            $table->string('vrucentrem', 11);
            $table->string('vuniorgrem', 250);
            $table->char('ctipdociderem', 1)->comment('1 = DNI, 2 = CARNET DE EXTRANJERIA');
            $table->string('vnumdociderem', 9);
            $table->string('vnumregstd', 10)->nullable();
            $table->string('vanioregstd', 4)->nullable();
            $table->string('vuniorgstd', 250)->nullable();
            $table->char('ccoduniorgstd', 15)->nullable();
            $table->string('vdesanxstd', 750)->nullable();
            $table->date('dfecregstd')->nullable();
            $table->string('vusuregstd', 100)->nullable();
            $table->binary('bcarstd')->nullable();//revisar
            $table->string('vcuo', 10);
            $table->string('vcuoref', 10)->nullable();
            $table->string('vobs', 250)->nullable();
            $table->char('cflgest', 1)->comment('P = PENDIENTE, R = REGISTRADO STD, N = NOTIFICADOS, O = OBSERVADO');
            $table->string('vusumod', 15)->nullable();
            $table->date('dfecmod')->nullable();
            $table->char('cflgestobs',1)->default('N')->nullable();
            $table->char('cflgenvcar', 1)->default('N')->nullable();//no aparece en el modelo
            $table->char('cflganu', 1)->default('N')->nullable();
            $table->dateTime('dfecreg')->default(now());
            //$table->integer('nflgfirmacar')->nullable();//no aparece en el modelo

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
        Schema::dropIfExists('iotdtc_recepcion');
    }
}

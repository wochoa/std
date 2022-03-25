<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespachosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iotdtc_despacho', function (Blueprint $table) {
            $table->bigIncrements('sidemiext');
            $table->string('vnumregstd', 10)->nullable();
            $table->string('vanioregstd', 4)->nullable();
            $table->char('ctipdociderem', 1)->comment('1 = DNI, 2 = CARNET DE EXTRANJERIA');
            $table->string('vnumdociderem', 9);
            $table->string('vcoduniorgrem', 15)->nullable();
            $table->string('vuniorgrem', 250)->nullable();
            $table->string('vcuo', 10)->nullable();
            $table->string('vrucentrec', 11);
            $table->string('vnomentrec', 200);
            $table->string('vnumregstdrec', 14)->nullable();
            $table->string('vanioregstdrec', 4)->nullable();
            $table->string('vuniorgstdrec', 250)->nullable();
            $table->string('vdesanxstdrec', 750)->nullable();
            $table->date('dfecregstdrec')->nullable();
            $table->string('vusuregstdrec', 150)->nullable();
            $table->binary('bcarstdrec')->nullable();
            $table->string('vobs', 250)->nullable();
            $table->string('vcuoref', 10)->nullable();
            $table->char('cflgest', 1)->default('P')->comment('ESTADO DEL DOCUMENTO P = PENDIENTE, E = ENVIADO, R = RECIBIDO, O = OBSERVADO, S = SUBSANADO, N = NO PRESENTADO');
            $table->char('cflgenv', 1)->default('N');//no aparece en el manual
            $table->date('dfecenv')->nullable();
            $table->string('vusureg', 15);
            $table->date('dfecreg')->default(now());
            $table->string('vusumod', 15)->nullable();
            $table->date('dfecmod')->nullable();

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
        Schema::dropIfExists('iotdtc_despacho');
    }
}

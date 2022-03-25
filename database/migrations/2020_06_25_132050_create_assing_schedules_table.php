<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assing_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('dependencia_id');
            $table->decimal('status', 1, 0)->default(1)->comment('0 = inactivo; 1 = activo');
            $table->decimal('type',1 ,0)->default(1)->comment('0 = control asistencia; 1 = atención mpv');
            $table->time('entry_time');
            $table->time('output_time');
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
        Schema::dropIfExists('assing_schedules');
    }
}

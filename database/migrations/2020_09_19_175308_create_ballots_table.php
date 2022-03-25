<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBallotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ballots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('dependencia_id');
            $table->integer('departure_reason')->comment('1 = COMISION; 2 = SALUD; 3 = PARTICULAR; 4 = COBRO DE HABERES 1H');
            $table->string('destination', 250);
            $table->string('justification', 250);
            $table->timestamp('exit')->nullable(); 
            $table->timestamp('return')->nullable();
            $table->decimal('authorized', 1, 0)->default(0);
            $table->integer('authorized_user_id')->nullable();
            $table->timestamp('authorized_updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable()->unsigned();
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
        Schema::dropIfExists('ballots');
    }
}

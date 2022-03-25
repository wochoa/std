<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('entry')->useCurrent();
            $table->timestamp('exit')->nullable();
            $table->bigInteger('dependencia_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('validate')->default(0)->unsigned();
            $table->string('created_ip', 30);
            $table->string('updated_ip', 30)->nullable();
            $table->time('entry_time')->nullable();
            $table->time('output_time')->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assistances');
    }
}

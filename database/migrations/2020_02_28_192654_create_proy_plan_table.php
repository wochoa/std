<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proy_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_comp_id')->nullable();
            $table->char('plan_fftt', 2)->default('00');
            $table->char('plan_id_clasifi', 7)->nullable();
            $table->integer('plan_anio')->nullable();
            $table->integer('version_id')->nullable()->default(1);
            $table->integer('plan_proyecto')->nullable();
            $table->decimal('plan_m1', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m2', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m3', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m4', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m5', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m6', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m7', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m8', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m9', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m10', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m11', 11, 2)->nullable()->default(0.00);
            $table->decimal('plan_m12', 11, 2)->nullable()->default(0.00);
            $table->timestamps();
            //index
            $table->index(['plan_comp_id', 'plan_fftt', 'plan_id_clasifi', 'plan_proyecto'], 'proy_plan_indx1');
            $table->index('version_id', 'fk1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proy_plan');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlannerEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planner_equipment', function (Blueprint $table) {
            $table->id();
            $table->integer('planner_id')->unsigned()->index();
            $table->integer('package_equipment_id')->unsigned()->index();
            $table->integer("return_qty")->default(0);
            $table->integer("missing_qty")->default(0);
            $table->string("status")->default('idle');
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
        Schema::dropIfExists('planner_equipment');
    }
}

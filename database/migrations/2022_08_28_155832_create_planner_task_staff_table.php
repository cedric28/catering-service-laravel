<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlannerTaskStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planner_task_staff', function (Blueprint $table) {
            $table->id();
            $table->integer('planner_task_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->date('task_date');
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
        Schema::dropIfExists('planner_task_staff');
    }
}

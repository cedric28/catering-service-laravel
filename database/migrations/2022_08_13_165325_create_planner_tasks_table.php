<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlannerTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planner_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('planner_id')->unsigned()->index();
            $table->integer('package_task_id')->unsigned()->index();
            // $table->integer('user_id')->unsigned()->index()->default(0);
            $table->date('task_date');
            $table->string('task_time');
            $table->string("task_type")->default('pre-event');
            $table->string("status")->default('pending');
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
        Schema::dropIfExists('planner_tasks');
    }
}

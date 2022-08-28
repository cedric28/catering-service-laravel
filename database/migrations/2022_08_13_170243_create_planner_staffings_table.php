<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlannerStaffingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planner_staffings', function (Blueprint $table) {
            $table->id();
            $table->integer('planner_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->string("attendance")->default('-');
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
        Schema::dropIfExists('planner_staffings');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageMenuPlannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_menu_planner', function (Blueprint $table) {
            $table->unsignedBigInteger('package_menu_id');
            $table->foreign('package_menu_id')->references('id')->on('package_menus');
            $table->unsignedBigInteger('planner_id');
            $table->foreign('planner_id')->references('id')->on('planners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_menu_planners');
    }
}

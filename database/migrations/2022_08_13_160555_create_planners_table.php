<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planners', function (Blueprint $table) {
            $table->id();
            $table->string('or_no')->unique;
            $table->string("event_name")->unique();
            $table->string("event_venue");
            $table->integer("no_of_guests");
            $table->date('event_date');
            $table->string('event_time');
            $table->integer('package_id')->unsigned()->index();
            $table->longText("note")->nullable();
            $table->string("status")->default('upcoming');
            $table->integer("payment_status_id")->unsigned()->index();
            $table->decimal('total_price', 10, 2);
            $table->integer('customer_id')->unsigned()->index();
            $table->integer('creator_id')->unsigned()->index();
            $table->integer('updater_id')->unsigned()->index();
            $table->softDeletes();
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
        Schema::dropIfExists('planners');
    }
}

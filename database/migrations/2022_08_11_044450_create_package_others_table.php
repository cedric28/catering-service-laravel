<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_others', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->decimal('service_price', 10, 2);
            $table->integer('package_id')->unsigned()->index();
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
        Schema::dropIfExists('package_others');
    }
}

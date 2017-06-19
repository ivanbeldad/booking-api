<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('bookings', function (Blueprint $table) {
		    $table->increments('id');
		    $table->unsignedInteger('user_id');
		    $table->unsignedInteger('service_time_id');
		    $table->boolean('confirmed')->default(false);
		    $table->decimal('total_price', 8, 2);
		    $table->smallInteger('slots_reserved');
		    $table->foreign('user_id')->references('id')->on('users');
		    $table->foreign('service_time_id')->references('id')->on('services_times');
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
	    Schema::dropIfExists('bookings');
    }
}

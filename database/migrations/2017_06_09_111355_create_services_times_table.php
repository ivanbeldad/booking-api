<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTimesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services_times', function (Blueprint $table) {
			$table->increments('id');
			$table->dateTime('start');
			$table->dateTime('end');
			$table->unsignedInteger('service_id');
			$table->foreign('service_id')->references('id')->on('services');
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
		Schema::dropIfExists('services_times');
	}
}

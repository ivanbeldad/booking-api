<?php

use App\Service;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ServicesTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $services = Service::all();
	    foreach ($services as $service) {
	    	$weeks = rand(2, 10);
		    $weekDay = Carbon::now()->startOfWeek()->addDay(rand(0, 5))->minute(0)->second(0);
		    $start = $weekDay->hour(rand(8, 14));
		    $end = $weekDay->hour($weekDay->hour + rand(1, 2));
		    for($i = 0; $i < $weeks; $i++) {
			    DB::table('services_times')->insert([
				    'service_id' => $service->id,
				    'start' => $start,
				    'end' => $end,
				    'created_at' => Carbon::now(),
				    'updated_at' => Carbon::now(),
			    ]);
			    $weekDay->addWeek(1);
		    }
	    }
    }
}

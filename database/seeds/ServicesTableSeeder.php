<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $services = [
		    'African Drumming',
		    'Seniors Club',
		    'Buddy Club',
		    'Birthday Parties',
		    'Adult Drawing Classes',
		    'Elders Club',
	    ];
	    foreach ($services as $service) {
		    if (\App\Service::where('name', '=', $service)->first()) {
			    continue;
		    }
		    DB::table('services')->insert([
			    'name' => $service,
			    'description' => '',
			    'price' => round((float)rand(5000, 30000) / (float)1000, 2),
			    'slots' => rand(10, 30),
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now(),
		    ]);
	    }
    }
}

<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $usernames = [
		    'ivan',
		    'javi',
		    'adrian',
	    ];
	    foreach ($usernames as $username) {
	    	if (\App\User::where('username', '=', $username)->first()) {
	    		continue;
		    }
		    DB::table('users')->insert([
			    'username' => $username,
			    'email' => $username.'@goodwebsite.net',
			    'password' => bcrypt($username),
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now(),
		    ]);
	    }
    }
}

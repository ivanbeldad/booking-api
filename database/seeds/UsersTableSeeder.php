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
		    DB::table('users')->insert([
			    'username' => $username,
			    'email' => $username.'@goodwebsite.net',
			    'password' => bcrypt($username),
		    ]);
	    }
    }
}

<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
	/*
     * Securized routes
     */
	$api->group(['middleware' => 'auth:api'], function ($api) {
		/*
		 * Admin user routes
		 */
		$api->group(['middleware' => 'scopes:admin'], function ($api) {
			$api->post('/users', 'App\Http\Controllers\UserController@store');
			$api->get('/users', 'App\Http\Controllers\UserController@index');

			$api->post('/services', 'App\Http\Controllers\ServiceController@store');
			$api->delete('/services/{id}', 'App\Http\Controllers\ServiceController@destroy');

			$api->post('/services/{service_id}/services_times', 'App\Http\Controllers\ServiceTimeController@store');
			$api->delete('/services/{service_id}/services_times/{id}', 'App\Http\Controllers\ServiceTimeController@destroy');
		});

		/*
		 * Basic user routes
		 */
		$api->group(['middleware' => 'scope:basic,admin'], function ($api) {
			$api->get('/user', 'App\Http\Controllers\UserController@show');
			$api->get('/users/{id}', 'App\Http\Controllers\UserController@show');

			/*
			 * BOOKINGS
			 */
			$api->get('/services/{service_id}/services_times/{service_time_id}/bookings', 'App\Http\Controllers\BookingController@index');
			$api->get('/services/{service_id}/services_times/{service_time_id}/bookings/{id}', 'App\Http\Controllers\BookingController@show');
			$api->post('/services/{service_id}/services_times/{service_time_id}/bookings', 'App\Http\Controllers\BookingController@store');
			$api->delete('/services/{service_id}/services_times/{service_time_id}/bookings/{id}', 'App\Http\Controllers\BookingController@destroy');
		});
	});

	/*
	 * Public routes
	 */
	$api->group([], function ($api) {
		$api->post('/login', 'App\Http\Controllers\LoginController@index');

		$api->get('/services', 'App\Http\Controllers\ServiceController@index');
		$api->get('/services/{id}', 'App\Http\Controllers\ServiceController@show');

		$api->get('/services/{service_id}/services_times', 'App\Http\Controllers\ServiceTimeController@index');
		$api->get('/services/{service_id}/services_times/{id}', 'App\Http\Controllers\ServiceTimeController@show');
	});
});

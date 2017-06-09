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
		$api->get('/user', 'App\Http\Controllers\UserController@show');
		$api->get('/users/{id}', 'App\Http\Controllers\UserController@show');
	});

	/*
	 * Public routes
	 */
	$api->group([], function ($api) {
		$api->post('/login', 'App\Http\Controllers\LoginController@index');
		$api->post('/users', 'App\Http\Controllers\UserController@store');
		$api->get('/users', 'App\Http\Controllers\UserController@index');        // TEMP
	});
});

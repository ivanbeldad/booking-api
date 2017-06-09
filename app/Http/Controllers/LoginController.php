<?php

namespace App\Http\Controllers;

use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Validator;

class LoginController extends Controller
{

	/**
	 * Get a token.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws AuthenticationException
	 */
    public function index(Request $request)
    {
	    $username = $request->input('username');
	    $password = $request->input('password');
	    $rules = [
		    'username' => 'required',
		    'password' => 'required',
	    ];
	    $validator = Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
		    throw new ValidationHttpException($validator->errors());
	    }

	    if (!Auth::attempt(['username' => $username, 'password' => $password])) {
		    throw new AuthenticationException();
	    }

	    $request->header('Content-Type', 'application/json');

	    $request->request->add([
		    'grant_type' => 'password',
		    'username' => $username,
		    'password' => $password,
		    'client_id' => '2',
		    'client_secret' => 'rWWwgwlpGgjlYeIsYu8qIXi4bodp7jMOp1aVi3ja',
		    'scope' => '*',
	    ]);

	    $proxy = Request::create(
		    'oauth/token',
		    'POST'
	    );

	    return Route::dispatch($proxy);
    }
}

<?php

namespace App\Http\Controllers;

use App\User;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return User::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$rules = [
		    'username' => 'required|unique:users,username|max:255',
		    'email' => 'required|email|unique:users,email|max:255',
		    'password' => 'required|min:8',
	    ];
	    $validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			throw new ValidationHttpException($validator->errors());
		}

		$user = new User([
			'username' => $request->input('username'),
			'email' => $request->input('email'),
			'password' => bcrypt($request->input('password')),
		]);

	    $user->save();

	    $user = User::where('username', '=', $request->input('username'))->firstOrFail();

	    return $user;
    }

	/**
	 * Display the specified resource.
	 *
	 * @param Request $request
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function show(Request $request, $id = null)
    {
        if (!$id) {
	        return $request->user();
        }
	    return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

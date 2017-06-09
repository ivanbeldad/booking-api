<?php

namespace App\Http\Controllers;

use App\Service;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
	use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    return Service::paginate(10);
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
		    'name' => 'required|unique:services,name|max:255',
		    'price' => 'required|numeric',
		    'slots' => 'required|numeric',
	    ];
	    $validator = Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
		    throw new ValidationHttpException($validator->errors());
	    }

	    return Service::create([
            'name' => $request->input('name'),
		    'description' => $request->input('description'),
		    'slots' => $request->input('slots'),
		    'price' => $request->input('price'),
	    ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    $service = Service::find($id);

	    return $service ? $service : $this->response->noContent();
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
	    Service::destroy($id);

	    return $this->response->noContent();
    }
}

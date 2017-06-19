<?php

namespace App\Http\Controllers;

use App\Service;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceTimeController extends Controller
{
	use Helpers;

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 *
	 * @param $service_id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index(Request $request, $service_id)
    {
    	$query = DB::table('services_times')->where('service_id', '=', $service_id);
	    $year = $request->input('year');
	    $month = $request->input('month');
	    $day = $request->input('day');
	    if ($year) {
		    $query->whereYear('start', $year);
	    }
	    if ($month) {
		    $query->whereMonth('start', $month);
	    }
	    if ($day) {
		    $query->whereDay('start', $day);
	    }
	    return $query->paginate(10);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param $service_id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function store(Request $request, $service_id)
    {
	    $rules = [
		    'start' => 'required|date',
		    'end' => 'required|date',
	    ];
	    $validator = Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
		    throw new ValidationHttpException($validator->errors());
	    }

	    return Service::findOrFail($service_id)->services_times()->create([
		    'start' => $request->input('start'),
		    'end' => $request->input('end'),
	    ]);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $service_id
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function show($service_id, $id)
    {
    	$service = Service::findOrFail($service_id);
    	$serviceTime = $service->services_times()->findOrFail($id);

	    return $serviceTime ? $serviceTime : $this->response->noContent();
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
	 * @param $service_id
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function destroy($service_id, $id)
    {
	    Service::findOrFail($service_id)->services_times()->delete($id);

	    return $this->response->noContent();
    }
}

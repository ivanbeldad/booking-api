<?php

namespace App\Http\Controllers;

use App\Booking;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class BookingController extends Controller
{
	use Helpers;

	/**
	 * Display a listing of the resource.
	 *
	 * @param $service_time_id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index($service_time_id)
    {
	    return Booking::all()->where('service_time_id', '=', $service_time_id)->paginate(10);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param $service_id
	 * @param $service_time_id
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function store($service_id, $service_time_id, Request $request)
    {
	    $slots_reserved = $request->input('slots_reserved');
	    $rules = [
		    'slots_reserved' => 'required|numeric',
	    ];
	    $validator = Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
		    throw new ValidationHttpException($validator->errors());
	    }

	    $service = Service::findOrFail($service_id);
	    $service_time = $service->services_times()->findOrFail($service_time_id);
	    $total_price = $service->price * $slots_reserved;
	    $other_bookings = $service_time->bookings();
	    $slots_remaining = $service->slots;
	    foreach ($other_bookings as $other_booking) {
		    $slots_remaining -= $other_booking->slots_reserved;
	    }

	    if ($slots_remaining < $slots_reserved) {
		    return $this->response->error('There are not enough slots');
	    }

	    return Service::findOrFail($service_id)->services_times()->findOrFail($service_time_id)->create([
		    'slots_reserved' => $slots_reserved,
		    'total_price' => $total_price,
		    'confirmed' => true,
	    ]);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $service_id
	 * @param $service_time_id
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function show($service_id, $service_time_id, $id)
    {
	    $service = Service::findOrFail($service_id);
	    $serviceTime = $service->services_times()->findOrFail($service_time_id);
		$booking = $serviceTime->bookings()->findOrFail($id);

	    return $booking ? $booking : $this->response->noContent();
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
	 * @param $service_time_id
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($service_id, $service_time_id, $id)
	{
		Service::findOrFail($service_id)->services_times()->findOrFail($service_time_id)->bookings()->delete($id);

		return $this->response->noContent();
	}
}

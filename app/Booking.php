<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
	public $table = 'bookings';
	public $timestamps = true;
	public $fillable = [
		'user_id',
		'service_time_id',
		'confirmed',
		'total_price',
		'slots_reserved',
	];
	public $hidden = [
	];

	public function service_time()
	{
		return $this->belongsTo('App\ServiceTime', 'service_time_id', 'id');
	}
}

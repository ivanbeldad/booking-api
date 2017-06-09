<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceTime extends Model
{
	public $table = 'services_times';
	public $timestamps = true;
	public $fillable = [
		'service',
		'start',
		'end',
	];
	public $hidden = [
	];

	public function service()
	{
		return $this->belongsTo('App\Service', 'service_id', 'id');
	}
}

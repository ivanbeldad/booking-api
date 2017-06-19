<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	public $table = 'services';
	public $timestamps = true;
	public $fillable = [
		'name',
		'description',
		'price',
		'slots',
	];
	public $hidden = [
	];

	public function services_times()
	{
		return $this->hasMany('App\ServiceTime', 'service_id', 'id');
	}
}

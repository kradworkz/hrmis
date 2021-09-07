<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
	protected $fillable = ['tagged', 'approved', 'disapproved'];

	public function reservation()
	{
		return $this->hasOne('hrmis\Models\Reservation', 'id', 'reservation_id');
	}
}
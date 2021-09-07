<?php

namespace hrmis\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LeaveDate extends Model
{
	protected $table 	= 'leave_dates';
    protected $guarded 	= [];
    protected $dates 	= ['date'];

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function leave()
    {
    	return $this->hasOne('hrmis\Models\Leave', 'id', 'leave_id');
    }
}
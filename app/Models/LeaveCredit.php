<?php

namespace hrmis\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LeaveCredit extends Model
{
	protected $table 	= 'leave_credits';
    protected $guarded 	= [];

    public function scopeYear($query, $year)
    {
        return $query->where('year', '=', $year);
    }

    public function leave()
    {
    	return $this->hasOne('hrmis\Models\Leave', 'id', 'leave_id');
    }
}
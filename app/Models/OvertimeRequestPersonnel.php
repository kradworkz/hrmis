<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeRequestPersonnel extends Model
{
	protected $table 	= 'overtime_request_personnel';
	protected $fillable = ['tagged', 'recommending_approved', 'recommending_disapproved', 'approved', 'disapproved'];
}
<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $table 		= 'notifications';
    protected $fillable 	= ['recipient_id', 'sender_id', 'unread', 'reference_id', 'type', 'parameters', 'action'];

    public function employee()
    {
    	return $this->hasOne('hrmis\Models\Employee', 'id', 'sender_id');
    }

    public function reference()
    {
        if($this->type == 'Vehicle Reservation') {
            return $this->hasOne('hrmis\Models\Reservation', 'id', 'reference_id');
        }
    	elseif($this->type == 'Travel Order') {
    		return $this->hasOne('hrmis\Models\Travel', 'id', 'reference_id');
    	}
        elseif($this->type == 'Offset') {
            return $this->hasOne('hrmis\Models\Offset', 'id', 'reference_id');
        }
        elseif($this->type == 'Overtime Request') {
            return $this->hasOne('hrmis\Models\OvertimeRequest', 'id', 'reference_id');
        }
        elseif($this->type == 'Attendance') {
            return $this->hasOne('hrmis\Models\Attendance', 'id', 'reference_id')->withoutGlobalScopes();
        }
        elseif($this->type == 'Leave') {
            return $this->hasOne('hrmis\Models\Leave', 'id', 'reference_id');
        }
        elseif($this->type == 'Health Check') {
            return $this->hasOne('hrmis\Models\EmployeeQuarantine', 'id', 'reference_id');
        }
    }
}
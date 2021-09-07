<?php

namespace hrmis\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ApprovalStatus extends Model
{
	protected $table 	= 'approval_status';
	protected $fillable = ['module', 'module_id', 'employee_id', 'action'];
	protected $dates 	= ['created_at', 'updated_at'];

	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}

	public function travels()
	{
		return $this->hasOne('hrmis\Models\Travel', 'id', 'module')->where('module_id', '=', 2);
	}

	public function module_name()
	{
		return $this->hasOne('hrmis\Models\Module', 'id', 'module_id');
	}

	public function reference()
    {
        if($this->module_id == 1) {
            return $this->hasOne('hrmis\Models\Reservation', 'id', 'module');
        }
    	elseif($this->module_id == 2) {
    		return $this->hasOne('hrmis\Models\Travel', 'id', 'module');
    	}
        elseif($this->module_id == 3) {
            return $this->hasOne('hrmis\Models\Offset', 'id', 'module');
        }
        elseif($this->module_id == 4) {
            return $this->hasOne('hrmis\Models\OvertimeRequest', 'id', 'module');
        }
        elseif($this->module_id == 5) {
            return $this->hasOne('hrmis\Models\Attendance', 'id', 'module')->withoutGlobalScopes();
        }
        elseif($this->module_id == 6) {
            return $this->hasOne('hrmis\Models\Leave', 'id', 'module');
        }
        elseif($this->module_id == 7) {
            return $this->hasOne('hrmis\Models\EmployeeQuarantine', 'id', 'module');
        }
    }
}
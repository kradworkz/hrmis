<?php

namespace hrmis\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
	protected $table 	= 'leave';
    protected $guarded 	= [];
    protected $dates 	= ['start_date', 'end_date', 'as_of'];

    public function comments()
    {
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 6);
    }

    public function leave_dates()
    {
    	return $this->hasMany('hrmis\Models\LeaveDate', 'leave_id', 'id');
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getOffDatesAttribute($value)
    {
        return $this->start_date == $this->end_date ? $this->start_date->format('F j, Y') : ($this->start_date->format('F') == $this->end_date->format('F') ? $this->start_date->format('F j')."-".$this->end_date->format('j, Y') : $this->start_date->format('F j, Y')."-".$this->end_date->format('F j, Y'));
    }

    public function setAsOfAttribute($value)
    {
        $this->attributes['as_of'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function approval_status()
    {
        return $this->hasMany('hrmis\Models\ApprovalStatus', 'module', 'id')->where('module_id', '=', 6);
    }

    public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }

    public function tagged_employees()
    {
        $leave          = collect([]);
        $leave[]        = $this->employee;
        $signatories    = getEmployeeSignatory(Auth::user()->unit_id, 6);
        $signatories->map(function($item) {
            $item['route'] = 'View Leave Approval';
        });
        $signatories    = $signatories->merge($leave);
        return $signatories;
    }

    public function scopeEmployees($query, $search = '')
    {
        return $query->whereHas('employee', function($employee) use($search) {
                    $employee->where('first_name', 'like', "%$search%")
                             ->orWhere('middle_name', 'like', "%$search%")
                             ->orWhere('last_name', 'like', "%$search%");
                });
    }

    public function scopeSignatory($query, $signatories = '', $signatory = '')
    {
        return $query->whereHas('employee', function($employee) use($signatories, $signatory) {
                    $employee->whereHas('unit', function($unit) use($signatories, $signatory) {
                        $unit->where($signatory == 'Approval' ? 'leave_approval' : 'leave_recommending', '=', 1)->whereIn('id', $signatories);
                    });
                });
    }

    public function scopeSignature($query, $status, $signatory = '')
    {
        if($signatory == 'Approval') {
            return $query->where('recommending', '=', 1)->where('approval', '=', $status);
        }
        elseif($signatory == 'Recommending') {
            return $query->where('recommending', '=', $status);
        }
        elseif($signatory == 'Notification') {
            return $query->where('checked', '=', $status);
        }
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeMonth($query, $month)
    {
        if($month == 00) {
            return null;
        }
        else {
            return $query->whereMonth('start_date', '=', $month);
        }
    }

    public function scopeYear($query, $year)
    {
        return $query->whereYear('start_date', '=', $year);
    }

    public function chief_signature()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'chief_approval_by');
    }

    public function recommending_signature()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'recommending_by');
    }

    public function approving_signature()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'approval_by');
    }
}
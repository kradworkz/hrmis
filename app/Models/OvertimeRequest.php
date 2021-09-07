<?php

namespace hrmis\Models;

use Carbon\Carbon, Auth;
use Illuminate\Database\Eloquent\Model;

class OvertimeRequest extends Model
{
    protected $table        = 'overtime_request';
    protected $fillable 	= ['employee_id', 'purpose', 'remarks', 'start_date', 'end_date', 'type', 'checked', 'recommending', 'approval', 'checked_by', 'recommending_by', 'approval_by', 'recommending_notification', 'approval_notification', 'is_active'];
    protected $dates 		= ['start_date', 'end_date'];

	public function setStartDateAttribute($value)
    {
    	$this->attributes['start_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setEndDateAttribute($value)
    {
    	$this->attributes['end_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }

    public function inspected_by()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'checked_by');
    }

    public function getOvertimeDatesAttribute($value)
    {
        return $this->start_date == $this->end_date ? $this->start_date->format('F j, Y') : ($this->start_date->format('F') == $this->end_date->format('F') ? $this->start_date->format('F j')."-".$this->end_date->format('j, Y') : $this->start_date->format('F j, Y')."-".$this->end_date->format('F j, Y'));
    }

    public function overtime_personnel()
    {
    	return $this->belongsToMany('hrmis\Models\Employee', 'overtime_request_personnel', 'overtime_request_id', 'employee_id')->withPivot('tagged', 'approved', 'disapproved');
    }

    public function comments()
    {
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 4);
    }

    public function employee_comments()
    {
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 4)->where('employee_id', '!=', \Auth::id());
    }

    public function overtime_personnel_names()
    {
        $names = '';
        foreach($this->overtime_personnel as $key => $employee) {
            $names .= $employee->semi_initials.", ";
        }

        return $names;
    }

    public function recommending_signature()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'recommending_by');
    }

    public function approving_signature()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'approval_by');
    }

    public function approval_status()
    {
        return $this->hasMany('hrmis\Models\ApprovalStatus', 'module', 'id')->where('module_id', '=', 4);
    }

    public function scopeSignatory($query, $signatories = '', $signatory = '')
    {
        return $query->whereHas('employee', function($employee) use($signatories, $signatory) {
                    $employee->whereHas('unit', function($unit) use($signatories, $signatory) {
                        $unit->where($signatory == 'Approval' ? 'overtime_approval' : 'overtime_recommending', '=', 1)->whereIn('id', $signatories);
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

    public function scopeEmployees($query, $search = '')
    {
        return $query->whereHas('employee', function($employee) use($search) {
                    $employee->where('first_name', 'like', "%$search%")
                             ->orWhere('middle_name', 'like', "%$search%")
                             ->orWhere('last_name', 'like', "%$search%");
                });
    }

    public function scopeTagged($query, $id)
    {
        return $query->where(function($sub_query) use($id) {
                     $sub_query->where('employee_id', '=', $id)->orWhereHas('overtime_personnel', function($overtime_personnel) use($id) {
                         $overtime_personnel->where('overtime_request_personnel.employee_id', '=', $id);
                     });
                 });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use($search) {
                 $query->where('purpose', 'like', "%$search%");
             });
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

    public function tagged_employees()
    {
        $users       = collect([]);
        // $users[]     = $this->employee;
        foreach($this->overtime_personnel as $passenger) {
            $users[] = $passenger;
        }

        $signatories = getEmployeeSignatory(Auth::user()->unit_id, 4);
        $signatories->map(function($item) {
            $item['route'] = 'View Overtime Approval';
        });
        $users       = $users->merge($signatories);
        return $users;
    }
}
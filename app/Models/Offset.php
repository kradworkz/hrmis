<?php

namespace hrmis\Models;

use Carbon\Carbon, Auth;
use Illuminate\Database\Eloquent\Model;

class Offset extends Model
{
	protected $table 		= 'offset';
    protected $fillable 	= ['employee_id', 'date', 'time', 'hours', 'remarks', 'verified', 'checked', 'recommending', 'approval', 'verified_by', 'checked_by', 'recommending_by', 'approval_by', 'recommending_notification', 'approval_notification', 'is_positive', 'is_active'];
	protected $dates 		= ['date'];

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d');
    }
    
	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}

    public function comments()
    {
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 3);
    }

    public function inspected_by()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'checked_by');
    }

    public function recommending_signature()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'recommending_by');
    }

    public function approving_signature()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'approval_by');
    }

    public function employee_comments()
    {
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 3)->where('employee_id', '!=', \Auth::id());
    }

    public function approval_status()
    {
        return $this->hasMany('hrmis\Models\ApprovalStatus', 'module', 'id')->where('module_id', '=', 3);
    }

    public function scopeSignatory($query, $signatories = '', $signatory = '')
    {
        return $query->whereHas('employee', function($employee) use($signatories, $signatory) {
                    $employee->whereHas('unit', function($unit) use($signatories, $signatory) {
                        $unit->where($signatory == 'Approval' ? 'offset_approval' : 'offset_recommending', '=', 1)->whereIn('id', $signatories);
                    });
                });
    }

    public function scopeSignature($query, $status, $signatory = '')
    {
        if($signatory == 'Approval') {
            return $query->where('recommending', '=', 1)->where('approval', '=', $status);
        }
        elseif($signatory == 'Recommending') {
            return $query->where('checked', '=', 1)->where('recommending', '=', $status);
        }
        elseif($signatory == 'Notification') {
            return $query->where('checked', '=', $status);
        }
        // elseif($signatory == 'Human Resource') {
        //     return $query->where('verified', '=', $status);
        // }
    }

    public function scopeEmployees($query, $search = '')
    {
        return $query->whereHas('employee', function($employee) use($search) {
                    $employee->where('first_name', 'like', "%$search%")
                             ->orWhere('middle_name', 'like', "%$search%")
                             ->orWhere('last_name', 'like', "%$search%");
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
            return $query->whereMonth('date', '=', $month);
        }
    }

    public function scopeYear($query, $year)
    {
        return $query->whereYear('date', '=', $year);
    }

    public function tagged_employees()
    {
        $offset         = collect([]);
        $offset[]       = $this->employee;
        $signatories    = getEmployeeSignatory(Auth::user()->unit_id, 3);
        $signatories->map(function($item) {
            $item['route'] = 'View Offset Approval';
        });
        $signatories    = $signatories->merge($offset);
        return $signatories;
    }

    public function scopeRecent($query)
    {
        if(Auth::user()->is_hr()) {
            return $query->whereMonth('date', '>=', 03)->whereYear('date', '>=', date('Y'));
        }
        else {
            return $query->where('created_at', '>', (new Carbon)->subMonths(3));
        }
    }

    public function attachment()
    {
        return $this->hasOne('hrmis\Models\Attachment', 'module_id', 'id')->where('module_type', '=', 3);
    }
}
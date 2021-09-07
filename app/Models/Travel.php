<?php

namespace hrmis\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table        = 'travels';
	protected $fillable 	= ['employee_id', 'purpose', 'destination', 'start_date', 'end_date', 'time', 'time_mode', 'remarks', 'mode_of_travel', 'checked', 'recommending', 'approval', 'checked_by', 'recommending_by', 'approval_by', 'recommending_notification', 'approval_notification', 'is_active'];
	protected $dates 		= ['start_date', 'end_date'];

	public function setStartDateAttribute($value)
    {
    	$this->attributes['start_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setEndDateAttribute($value)
    {
    	$this->attributes['end_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getTravelDatesAttribute($value)
    {
        return $this->start_date == $this->end_date ? $this->start_date->format('F j, Y') : ($this->start_date->format('F') == $this->end_date->format('F') ? $this->start_date->format('F j')."-".$this->end_date->format('j, Y') : $this->start_date->format('F j, Y')."-".$this->end_date->format('F j, Y'));
    }

    public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }

    public function inspected_by()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'checked_by');
    }

	public function comments()
    {
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 2);
    }

    public function travel_passengers()
    {
    	return $this->belongsToMany('hrmis\Models\Employee', 'travel_passengers', 'travel_id', 'employee_id')->withPivot('tagged', 'approved', 'disapproved');
    }

    public function tagged_employees()
    {
        $users       = collect([]);
        // $users[]     = $this->employee;
        foreach($this->travel_passengers as $passenger) {
            $users[] = $passenger;
        }
        $signatories = getEmployeeSignatory(Auth::user()->unit_id, 2);
        $signatories->map(function($item) {
            $item['route'] = 'View Travel Approval';
        });
        $users       = $users->merge($signatories);
        return $users;
    }

    public function travel_passenger_names()
    {
        $i      = 0;
        $names  = '';
        $length = count($this->travel_passengers);
        foreach($this->travel_passengers as $key => $employee) {
            if($i == $length - 1) {
                $names .= $employee->semi_initials;
            }
            else {
                $names .= $employee->semi_initials.", ";
            }
            $i++;
        }

        return $names;
    }
    
    public function travel_documents()
    {
        return $this->hasMany('hrmis\Models\TravelDocument');
    }

    public function travel_funds_expenses()
    {
        return $this->belongsToMany('hrmis\Models\TravelExpense', 'travel_funds_expenses', 'travel_id', 'expense_id')->withPivot('fund_id')->withTimestamps();
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
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 2)->where('employee_id', '!=', \Auth::id());
    }

    public function approval_status()
    {
        return $this->hasMany('hrmis\Models\ApprovalStatus', 'module', 'id')->where('module_id', '=', 2);
    }

    public function scopeSignatory($query, $signatories = '', $signatory = '')
    {
        return $query->whereHas('employee', function($employee) use($signatories, $signatory) {
                    $employee->whereHas('unit', function($unit) use($signatories, $signatory) {
                        $unit->where($signatory == 'Approval' ? 'travel_approval' : 'travel_recommending', '=', 1)->whereIn('id', $signatories);
                    });
                });
    }

    public function scopeSignature($query, $status, $signatory = '')
    {
        if($signatory == 'Approval') {
            return $query->where('recommending', '=', 1)->where('approval', '=', $status);
        }
        elseif($signatory == 'Recommending') {
            if(Auth::user()->is_pd()) {
                return $query->where('recommending', '=', $status);
            }
            else {
                return $query->where('checked', '=', 1)->where('recommending', '=', $status);
            }
        }
        elseif($signatory == 'Notification') {
            return $query->where('checked', '=', $status)->orWhere('checked', '=', NULL);
        }
    }

    public function scopeEmployees($query, $search = '')
    {
        return $query->whereHas('employee', function($employee) use($search) {
                    $employee->where('first_name', 'like', "%$search%")
                             ->orWhere('middle_name', 'like', "%$search%")
                             ->orWhere('last_name', 'like', "%$search%")
                             ->orWhere('destination', 'like', "%$search%")
                             ->orWhere('purpose', 'like', "%$search%");
                });
    }

    public function scopeEmployee($query, $employee_id = '')
    {
        if($employee_id != '') {
            return $query->where(function($sub_query) use($employee_id) {
                     $sub_query->where('employee_id', '=', $employee_id)->orWhereHas('travel_passengers', function($travel_passengers) use($employee_id) {
                         $travel_passengers->where('travel_passengers.employee_id', '=', $employee_id);
                     });
                 });
        }
    }

    public function scopeTagged($query, $id)
    {
        return $query->where(function($sub_query) use($id) {
                     $sub_query->where('employee_id', '=', $id)->orWhereHas('travel_passengers', function($travel_passengers) use($id) {
                         $travel_passengers->where('travel_passengers.employee_id', '=', $id);
                     });
                 });
    }

    public function scopeBetween($query, $start_date, $end_date)
    {
        return $query->whereBetween('start_date', [$start_date, $end_date]);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use($search) {
                 $query->where('destination', 'like', "%$search%")->orWhere('purpose', 'like', "%$search%");
             });
    }

    public function scopeLocation($query, $location)
    {
        if($location) {
            return $query->whereHas('employee', function($employee) use($location) {
                $employee->whereHas('unit', function($unit)  use($location) {
                    $unit->where($location == 'Regional Office' ? 'location' : 'id', '=', $location);
                });
            });
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

    public function scopeRecent($query)
    {
        return $query->where('created_at', '>', (new Carbon)->subMonths(3));
    }
}
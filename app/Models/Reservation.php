<?php

namespace hrmis\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
	protected $fillable  	= ['vehicle_id', 'employee_id', 'trip_ticket', 'driver_name', 'purpose', 'destination', 'start_date', 'end_date', 'time', 'remarks', 'others', 'check', 'status', 'recommending', 'approval', 'status_by', 'checked_by', 'recommending_by', 'approval_by', 'location', 'is_pd', 'is_active', 'is_read'];
	protected $dates 		= ['start_date', 'end_date'];

	public function setStartDateAttribute($value)
    {
    	$this->attributes['start_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setEndDateAttribute($value)
    {
    	$this->attributes['end_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getReservationDatesAttribute($value)
    {
        return $this->start_date == $this->end_date ? $this->start_date->format('F j, Y') : ($this->start_date->format('F') == $this->end_date->format('F') ? $this->start_date->format('F j')."-".$this->end_date->format('j, Y') : $this->start_date->format('F j, Y')."-".$this->end_date->format('F j, Y'));
    }

    public function vehicle()
    {
        return $this->hasOne('hrmis\Models\Vehicle', 'id', 'vehicle_id')->where('is_active', '=', 1);
    }

    public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }

    public function dispatched_by()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'status_by');
    }

    public function covid_checked_by()
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

    public function passengers()
    {
        return $this->belongsToMany('hrmis\Models\Employee', 'passengers', 'reservation_id', 'employee_id')->withPivot('tagged', 'approved', 'disapproved');
    }

    public function tagged_employees()
    {
        $users       = collect([]);
        // $users[]     = $this->employee;
        foreach($this->passengers as $passenger) {
            $users[] = $passenger;
        }

        $signatories = getEmployeeSignatory(Auth::user()->unit_id, 1);
        $signatories->map(function($item) {
            $item['route'] = 'View Reservation Approval';
        });
        $users       = $users->merge($signatories);
        return $users;
    }

    public function passenger_names()
    {
        $names = '';
        $passengers_count = count($this->passengers);
        foreach($this->passengers as $key => $employee) {
            $names .= $employee->semi_initials.($key == $passengers_count - 1 ? '' : ', ');
        }

        return $names;
    }
    
    public function comments()
    {
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 1);
    }

    public function employee_comments()
    {
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 1)->where('employee_id', '!=', \Auth::id());
    }

    public function approval_status()
    {
        return $this->hasMany('hrmis\Models\ApprovalStatus', 'module', 'id')->where('module_id', '=', 1);
    }

    public function scopeDates($query, $date)
    {
        if($date) {
            $query->where('start_date', '<=', $date->format('Y-m-d'))->where('end_date', '>=', $date->format('Y-m-d'));
        }

        return $query;
    }

    public function scopeSignatory($query, $signatories = '')
    {
        return $query->whereHas('employee', function($employee) use($signatories) {
                $employee->whereIn('unit_id', $signatories);
            });
    }

    public function scopeEmployees($query, $search = '')
    {
        return $query->whereHas('employee', function($employee) use($search) {
                    $employee->where('first_name', 'like', "%$search%")
                             ->orWhere('middle_name', 'like', "%$search%")
                             ->orWhere('last_name', 'like', "%$search%")
                             ->orWhere('destination', 'like', "%$search%")
                             ->orWhere('purpose', 'like', "%$search%");
                })->orWhereHas('vehicle', function($vehicle) use($search) {
                    $vehicle->where('plate_number', 'like', "%$search%");
                });
    }

    public function scopeVehicle($query, $vehicle_id)
    {
        if($vehicle_id) {
            return $query->where('vehicle_id', '=', $vehicle_id);
        }

        return $query;
    }

    public function scopeSignature($query, $status, $signatory = '')
    {
        if($signatory == 'Approval') {
            return $query->where('recommending', '=', 1)->where('approval', '=', $status);
        }
        elseif($signatory == 'Recommending') {
            return $query->where('recommending', '=', $status);
        }
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }

    public function scopeTagged($query, $id)
    {
        if($id) {
           return $query->where(function($sub_query) use($id) {
                 $sub_query->where('employee_id', '=', $id)->orWhereHas('passengers', function($passengers) use($id) {
                     $passengers->where('passengers.employee_id', '=', $id);
                 });
             }); 
        }
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use($search) {
                 $query->where('destination', 'like', "%$search%")->orWhere('purpose', 'like', "%$search%")->orWhereHas('vehicle', function($vehicle) use($search) {
                     $vehicle->where('plate_number', 'like', "%$search%");
                 });
             });
    }

    public function scopeLocation($query)
    {
        if(Auth::user()->is_pd()) {
            return $query->where('location' ,'=', 1)->whereHas('vehicle', function($vehicle) {
                $vehicle->where('location', '=', Auth::user()->unit->location);
            });
        }
        else {
            return $query->where('location', '=', 0)->orWhere('is_pd', '=', 1);
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

    public function scopeFilter($query, $search = null, $date = null, $year = null, $month = null)
    {
        if($search) {
            $query->where(function($query) use($search) {
                $query->where('destination', 'like', "%$search%")->orWhere('purpose', 'like', "%$search%")->orWhereHas('vehicle', function($vehicle) use($search) {
                     $vehicle->where('plate_number', 'like', "%$search%");
                });
            });
        }
        
        if($date) {
            $query->dates($date);
            // $query->where('start_date', '>=', $date->format('Y-m-d'))->orWhere(function($query) use($date) {
            //     $query->dates($date);
            // });
        }

        return $query;
    }
}
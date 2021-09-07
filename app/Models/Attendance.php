<?php

namespace hrmis\Models;

use Carbon\Carbon, Auth;
use Carbon\CarbonPeriod;
use hrmis\Models\Travel;
use hrmis\Models\Employee;
use hrmis\Models\CalendarEvent;
use hrmis\Models\EmployeeSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
	protected $table 	     = 'attendance';
    protected $primaryKey    = 'id';
    protected $fillable      = ['employee_id', 'time_in', 'time_out', 'status', 'updated_by', 'location', 'ip_address'];
    protected $dates 	     = ['time_in', 'time_out'];
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function(Builder $builder) {
            $builder->where('status', '=', 1);
        });
    }

    public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }

    public function encoder()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'updated_by');
    }

    public function comments()
    {
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 5);
    }

    public function attachments()
    {
        return $this->hasMany('hrmis\Models\Attachment', 'module_id', 'id')->where('module_type', '=', 5);
    }

    public function late()
    {
        $late               = 0;
        $lunch_in           = "12:00";
        $lunch_out          = "13:00";
        $time_in            = $this->time_in->format('H:i');
        $time_out           = optional($this->time_out)->format('H:i');
        $employee_sched     = EmployeeSchedule::where('employee_id', '=', $this->employee_id)->where('day', '=', $this->time_in->format('N'))->first();
        if($employee_sched) {
            if($employee_sched->day != 1) {
                $late_in    = date("H:i", strtotime("+15 minutes", strtotime($employee_sched->time_in)));
            }
            else {
                $late_in    = "08:00";
            }

            if(strtotime($time_in) > strtotime($late_in) && strtotime($time_in) < strtotime($lunch_in)) {
                $late       = 1;
            }
            elseif(strtotime($time_in) > strtotime($lunch_out) && strtotime($time_in) < strtotime($employee_sched->time_out)) {
                $late       = 1;
            }
        }
        return $late;
    }

    public function earned()
    {
        $earned             = NULL;
        $lunch_in           = "12:00";
        $lunch_out          = "13:00";
        $time_in            = $this->time_in->format('H:i');
        $time_out           = optional($this->time_out)->format('H:i');
        $holiday            = CalendarEvent::where('date', '=', $this->time_in->format('Y-m-d'))->where('is_active', '=', 1)->first();
        $employee_sched     = EmployeeSchedule::where('employee_id', '=', $this->employee_id)->where('day', '=', $this->time_in->format('N'))->first();
        $scheduled_in       = $employee_sched != null ? $employee_sched->time_in : "08:00";
        $scheduled_out      = $employee_sched != null ? $employee_sched->time_out : "17:00";
        $adjusted_in        = date("H:i", (strtotime($scheduled_in))-(10*60));
        $adjusted_out       = date("H:i", (strtotime($scheduled_out))+(10*60));
        $grace_period       = (15*60);
        if($this->time_in && $this->time_out) {
            if($this->time_in->englishDayOfWeek == 'Monday') {
                if($time_in <= "07:50") {
                    $earned += getDifference($time_in, "08:00");
                }
                if($time_out >= "17:10") {
                    $earned += getDifference("17:00", $time_out);
                }
            }
            elseif($holiday || $this->time_in->englishDayOfWeek == 'Saturday' || $this->time_in->englishDayOfWeek == 'Sunday') {
                if($this->getBetween($time_out)) {
                    $earned = getDifference($time_in, "12:00");
                }
                elseif($this->getBetween($time_in)) {
                    $earned = getDifference("13:00", $time_out);
                }
                else {
                    if($time_out < "12:00") {
                        $earned = getDifference($time_in, $time_out);
                    }
                    elseif($time_in > "13:00") {
                        $earned = getDifference($time_in, $time_out);
                    }
                    else {
                        $am_earned  = getDifference($time_in, "12:00");
                        $pm_earned  = getDifference("13:00", $time_out);
                        $earned     = $am_earned+$pm_earned;
                    }
                }
                $earned = $earned*1.5;
                $earned = floor($earned);
            }
            else {
                $grace_period   = 0;
                $first_time_in  = $this->where('employee_id', '=', $this->employee_id)->whereDate('time_in', '=', $this->time_in->format('Y-m-d'))->first()->time_in->format('H:i');
                $last_time_out  = optional($this->where('employee_id', '=', $this->employee_id)->whereDate('time_in', '=', $this->time_in->format('Y-m-d'))->orderBy('time_in', 'desc')->first()->time_out)->format('H:i');
                
                if($first_time_in > $scheduled_in) {
                    $grace_period = getDifference($scheduled_in, $first_time_in);
                }
                
                if($time_in <= $adjusted_in) {
                    $earned += getDifference($time_in, $scheduled_in);
                }

                if($last_time_out > $scheduled_out) {
                    if(!$this->getBetween($time_out)) {
                        $overtime = getDifference($scheduled_out, $last_time_out)-$grace_period;

                        if($overtime >= 10) {
                            $earned += $overtime;
                        }
                    }
                    
                }
            }
        }

        return $earned;
    }

    function getBetween($value)
    {
        $value      = strtotime($value);
        $lunch_in   = strtotime("12:00");
        $lunch_out  = strtotime("13:00");
        if($value >= $lunch_in && $value <= $lunch_out) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function checkTravel()
    {
        $time_in            = Carbon::parse($this->t_in);
        $time_out           = $this->t_out != null ? Carbon::parse($this->t_out) : null;
        $travels            = Travel::whereYear('start_date', '=', $time_in->format('Y'))->whereMonth('start_date', '=', $time_in->format('m'))->where(function($query) {
                                $query->where('employee_id', '=', $this->employee_id)->orWhereHas('travel_passengers', function($passengers) {
                                    $passengers->where('travel_passengers.employee_id', '=', $this->employee_id);
                                });
                            })->where('approval', '=', 1)->get();

        $ob                 = null;
        foreach($travels as $travel) {
            if($travel->start_date == $travel->end_date) { /* Single Day */
                if($time_in->format('Y-m-d') == $travel->start_date->format('Y-m-d')) {
                    return $travel;
                }
            }
            else { /* Multiple Day */
                $dates      = CarbonPeriod::create($travel->start_date, $travel->end_date);
                foreach($dates as $date) {
                    if($time_in->format('Y-m-d') == $date->format('Y-m-d')) {
                        return $travel;
                    }
                }
            }
        }
        return $ob;
    }

    public function scopeTagged($query, $id)
    {
        return $query->where('employee_id', '=', $id);
    }

    public function scopeMonth($query, $month)
    {
        if($month == 00) {
            return null;
        }
        else {
            return $query->whereMonth('time_in', '=', $month);
        }
    }

    public function scopeYear($query, $year)
    {
        return $query->whereYear('time_in', '=', $year);
    }

    public function scopeChanged($query)
    {
        return $query->where('updated_by', '!=', NULL);
    }

    public function tagged_employees()
    {
        $hr      = Employee::where('is_active', '=', 1)->whereHas('roles', function($query) {
                    $query->where('role_id', '=', 9);
                })->get();
        $hr->map(function($item) {
            $item['route'] = 'View DTR Approval';
        });
        return $hr;
    }
}
<?php

namespace hrmis\Models;

use hrmis\Models\Offset;
use Carbon\CarbonPeriod;
use Carbon\Carbon, Hash, Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use SoftDeletes;

    protected $table    = 'employees';
    protected $appends  = array('full_name');
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'name_suffix', 'designation', 'email', 'username', 'password', 'suffix', 'prefix', 'salary', 'religion', 'emergency_contact_person', 'emergency_contact_number', 'signature', 'picture', 'unit_id', 'employee_status_id', 'is_active', 'is_admin', 'desktop_time_in', 'plantilla_item_number','contact_no'];
    protected $hidden   = ['password', 'remember_token'];

    public function setPasswordAttribute($value)
    {
    	return $this->attributes['password'] 	= Hash::make($value);
    }

    public function setFnameAttribute($value)
    {
    	$this->attributes['first_name'] 		= ucwords($value);
    }

    public function setMnameAttribute($value)
    {
        $this->attributes['middle_name']        = ucwords($value);
    }

    public function setLnameAttribute($value)
    {
    	$this->attributes['last_name'] 			= ucwords($value);
    }

    public function getFullNameAttribute($value)
    {
        return ucfirst($this->first_name).' '.ucfirst(substr($this->middle_name, 0, 1)).'. '.ucfirst($this->last_name);
    }

    public function getOrderByLastNameAttribute($value)
    {
        return ucwords(strtolower($this->last_name)).' '.ucwords($this->first_name).'. '.ucwords(substr($this->middle_name, 0, 1));
    }

    public function getInitialsAttribute($value)
    {
        return ucfirst(substr($this->first_name, 0, 1)).ucfirst(substr($this->middle_name, 0, 1)).", ".ucfirst(strtolower($this->last_name));
    }

    public function getSemiInitialsAttribute($value)
    {
        return ucfirst(substr($this->first_name, 0, 1)).ucfirst(substr($this->middle_name, 0, 1)).ucfirst($this->last_name);
    }

    public function getFullInitialsAttribute($value)
    {
        return ucfirst(substr($this->first_name, 0, 1)).ucfirst(substr($this->middle_name, 0, 1)).ucfirst(substr($this->last_name, 0, 1));
    }

    public function employee_roles()
    {
        return $this->hasMany('hrmis\Models\EmployeeRoles');
    }

    public function employee_groups()
    {
        return $this->hasMany('hrmis\Models\EmployeeGroups');
    }

    public function unit()
    {
        return $this->hasOne('hrmis\Models\Group', 'id', 'unit_id');
    }

    public function primary_group()
    {
        return $this->hasOne('hrmis\Models\EmployeeGroups')->where('is_primary', '=', 1);
    }

    public function roles()
    {
        return $this->belongsToMany('hrmis\Models\Role', 'employee_roles', 'employee_id', 'role_id');
    }

    public function groups()
    {
        return $this->belongsToMany('hrmis\Models\Group', 'employee_groups', 'employee_id', 'group_id');
    }
    public function signatories()
    {
        return $this->hasMany('hrmis\Models\Signatory');
    }

    public function reservation_signatory()
    {
        return $this->hasOne('hrmis\Models\Signatory')->where('module_id', '=', 1);
    }

    public function travel_signatory()
    {
        return $this->hasOne('hrmis\Models\Signatory')->where('module_id', '=', 2);
    }

    public function offset_signatory()
    {
        return $this->hasOne('hrmis\Models\Signatory')->where('module_id', '=', 3);
    }

    public function overtime_signatory()
    {
        return $this->hasOne('hrmis\Models\Signatory')->where('module_id', '=', 4);
    }

    public function leave_signatory()
    {
        return $this->hasOne('hrmis\Models\Signatory')->where('module_id', '=', 6);
    }

    public function health_signatory()
    {
        return $this->hasOne('hrmis\Models\Signatory')->where('module_id', '=', 7);
    }

    public function employee_offset()
    {
        return $this->hasMany('hrmis\Models\Offset')->latest('id');
    }

    public function offset()
    {
        return $this->hasMany('hrmis\Models\Offset')->where(\DB::raw('MONTH(date)'), '=', date('m'))->where(\DB::raw('YEAR(date)'), '=', date('Y'));
    }

    public function ob()
    {
        return $this->hasOne('hrmis\Models\Travel')->whereDate('end_date', '>=', date('Y-m-d'))->whereDate('start_date', '<=', date('Y-m-d'));
    }

    public function travel_order($id)
    {
        $month = date('m');
        $year  = date('Y');

        $travels = Travel::select('start_date', 'end_date')->where(function($query) use($id) {
            $query->where('employee_id', '=', $id)->orWhereHas('travel_passengers', function($travel_passengers) use($id) {
                $travel_passengers->where('travel_passengers.employee_id', '=', $id);
            });
        })->whereMonth('start_date', '=', $month)->whereYear('start_date', '=', $year)->orderBy('id', 'desc')->get();

        foreach($travels as $to) {
            if(Carbon::create(date('Y'), date('m'), date('d'))->between($to->start_date, $to->end_date, true)) {
                $travels = Travel::where(function($query) use($id) {
                    $query->where('employee_id', '=', $id)->orWhereHas('travel_passengers', function($travel_passengers) use($id) {
                        $travel_passengers->where('travel_passengers.employee_id', '=', $id);
                    });
                })->whereDate('start_date', '=', $to->start_date)->whereDate('end_date', '=', $to->end_date)->orderBy('id', 'desc')->first();

                return $travels;
            }
        }
    }

    public function tagged_travels()
    {
        return $this->hasOne('hrmis\Models\TravelPassenger');
    }

    public function offset_today()
    {
        return $this->hasOne('hrmis\Models\Offset')->where('date', '=', date('Y-m-d'));
    }

    public function dtr()
    {
        return $this->hasMany('hrmis\Models\Attendance');
    }

    public function attendance()
    {
        $date = request('date') == null ? date('Y-m-d') : Carbon::parse(request('date'))->format('Y-m-d');
        return $this->hasOne('hrmis\Models\Attendance')->whereDate('time_in', '=', $date);
    }

    public function whereabouts_time_in($date = null, $mode = 0)
    {
        if($date == null) {
            $date = Carbon::now();
        }

        if($mode == 0) {
            $attendance = Attendance::where('employee_id', '=', $this->id)->whereDate('time_in', '=', $date->format('Y-m-d'))->first();
            if($attendance) {
                if($attendance->location == 0) {
                    return "<a href='#' class='text-primary text-decoration-none' data-toggle='tooltip' data-title='Work from Home'>".$attendance->time_in->format('h:i A')."</a>";
                }
                else {
                    return $attendance->time_in->format('h:i A');
                }
            }
        }
        else {
            $attendance = Attendance::where('employee_id', '=', $this->id)->whereDate('time_in', '=', $date->format('Y-m-d'))->where('time_out', '!=', NULL)->latest()->first();
            if($attendance) {
                if($attendance->location == 0) {
                    return "<a href='#' class='text-primary text-decoration-none' data-toggle='tooltip' data-title='Work from Home'>".$attendance->time_out->format('h:i A')."</a>";
                }
                else {
                    return $attendance->time_out->format('h:i A');
                }
            }
        }

        
    }

    public function time_in()
    {
        return $this->hasOne('hrmis\Models\Attendance')->whereDate('time_in', '=', date('Y-m-d'));
    }

    public function time_out()
    {
        return $this->hasOne('hrmis\Models\Attendance')->whereDate('time_out', '=', date('Y-m-d'));
    }

    public function travels()
    {
        return $this->hasMany('hrmis\Models\Travel')->latest('id');
    }

    public function travel()
    {
        return $this->hasMany('hrmis\Models\Travel')->where(\DB::raw('MONTH(start_date)'), '=', date('m'))->where(\DB::raw('YEAR(start_date)'), '=', date('Y'));
    }

    public function employment_status()
    {
        return $this->hasOne('hrmis\Models\EmployeeStatus', 'id', 'employee_status_id');
    }

    public function logs()
    {
        return $this->hasOne('hrmis\Models\EmployeeLogs', 'employee_id', 'id')->orderBy('created_at', 'desc')->skip(1);
    }

    public function is_superuser()
    {
        return $this->roles()->where('name', 'Superuser')->exists();
    }

    public function is_administrator()
    {
        return $this->roles()->where('name', 'Administrator')->exists();
    }

    public function is_assistant()
    {
        return $this->roles()->where('name', 'Division Assistant')->exists();
    }

    public function is_head()
    {
        return $this->roles()->where('name', 'Division Head')->exists();
    }

    public function is_health_officer()
    {
        return $this->roles()->where('name', 'Health Officer')->exists();
    }

    public function is_hr()
    {
        return $this->roles()->where('name', 'Human Resource')->exists();
    }

    public function is_pd()
    {
        return $this->roles()->where('name', 'Provincial Director')->exists();
    }

    public function overtime()
    {
        return $this->hasMany('hrmis\Models\OvertimeCredit', 'employee_id', 'id')->latest('id');
    }

    public function last_overtime()
    {
        return $this->hasOne('hrmis\Models\OvertimeCredit', 'employee_id', 'id')->latest('id');
    }

    public function searchableAs()
    {
        return 'employees_index';
    }

    public function first_time_in()
    {
        return $this->hasOne('hrmis\Models\Attendance', 'employee_id', 'id')->where('employee_id', '=', $this->id)->first();
    }

    public function employee_coc()
    {
        return $this->hasOne('hrmis\Models\EmployeeCOC', 'employee_id', 'id')->where('latest_balance', '=', 1)->latest();
    }

    public function monthly_coc_earned()
    {
        return $this->hasOne('hrmis\Models\EmployeeCOC', 'employee_id', 'id')->where('type', '=', 1)->latest();
    }

    public function employee_balance_all()
    {
        if($this->employee_coc) {
            $balance = ($this->employee_coc->end_hours*60)+$this->employee_coc->end_minutes;
        }
        else {
            $balance = 0;
        }
        return $balance;
    }

    public function employee_balance()
    {
        if($this->employee_coc) {
            $balance = ($this->employee_coc->end_hours*60);
        }
        else {
            $balance = 0;
        }
        return $balance;
    }

    public function leave_credits()
    {
        return $this->hasOne('hrmis\Models\LeaveCredit', 'employee_id', 'id')->latest();
    }

    public function total_offset_year()
    {
        return Offset::where('employee_id', '=', Auth::id())->whereYear('date', '=', date('Y'))->sum('hours');
    }

    public function total_offset_month()
    {
        return Offset::where('employee_id', '=', Auth::id())->whereMonth('date', '=', date('m'))->whereYear('date', '=', date('Y'))->sum('hours');
    }

    public function notifications()
    {
        return $this->hasMany('hrmis\Models\Notification', 'recipient_id', 'id')->where('sender_id', '!=', Auth::id())->where('unread', '=', 0)->take(10)->latest('created_at');
    }

    public function notifications_all()
    {
        return $this->hasMany('hrmis\Models\Notification', 'recipient_id', 'id')->where('sender_id', '!=', Auth::id())->where('unread', '=', 0)->latest('created_at');
    }

    public function info()
    {
        return $this->hasOne('hrmis\Models\PersonalInformation', 'employee_id', 'id');
    }

    public function family()
    {
        return $this->hasOne('hrmis\Models\FamilyBackground', 'employee_id', 'id');
    }

    public function education()
    {
        return $this->hasOne('hrmis\Models\EducationalBackground', 'employee_id', 'id');
    }

    public function photo()
    {
        if($this->picture != "") {
            if(\Storage::disk('public')->exists('profile/'.$this->picture)) {
                return asset('storage/profile/'.$this->picture);
            }
            else {
                return asset('profile/default-profile.png');
            }
        }
        else {
            return asset('profile/default-profile.png');
        }
    }

    public function compute_attendance($mode = 0)
    {
        $value          = 0;
        if(\Request::has('start_date') && \Request::has('end_date')) {
            $start_date     = \Request::get('start_date') == null ? Carbon::parse(date('Y-m-d'))->firstOfMonth() : Carbon::parse(\Request::get('start_date'));
            $end_date       = \Request::get('end_date') == null ? Carbon::parse(date('Y-m-d'))->lastOfMonth() : Carbon::parse(\Request::get('end_date'));
        }
        else {
            $start_date     = Carbon::createFromDate(\Request::get('year'), \Request::get('month'), 1)->firstOfMonth();
            $end_date       = Carbon::createFromDate(\Request::get('year'), \Request::get('month'), 1)->lastOfMonth();
        }
        
        $days           = CarbonPeriod::create($start_date, $end_date);

        foreach($days as $day) {
            if($mode == 0) {
                if(getEmployeeLate($this->id, $day) != null) {
                    $value++;
                }
            }
            elseif($mode == 1) {
                if(getEmployeeEarned($this->id, $day, 1)) {
                    $value+= getEmployeeEarned($this->id, $day, 1);
                }
            }
        }

        return $value;
    }

    public function start_balance()
    {
        return $this->hasOne('hrmis\Models\EmployeeBalance', 'employee_id', 'id');
    }

    public function scopeStatus($query, $status)
    {
        if($status != null) {
            return $query->where('employee_status_id', '=', $status);
        }
    }

    public function scopeUnit($query, $unit)
    {
        if($unit != null) {
            return $query->where('unit_id', '=', $unit);
        }
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use($search) {
                 $query->where('first_name', 'like', "%$search%")->orWhere('middle_name', 'like', "%$search%")->orWhere('last_name', 'like', "%$search%");
             });
    }

    public function missing_timeout()
    {
        return $this->hasMany('hrmis\Models\Attendance')->whereDate('time_in', '!=', date('Y-m-d'))->whereYear('time_in', '=', date('Y'))->whereMonth('time_in', '=', date('m'))->where('time_out', '=', NULL)->get();
    }

    public function quarantine()
    {
        return $this->hasOne('hrmis\Models\EmployeeQuarantine', 'employee_id', 'id')->where(function($query) {
            $query->where('recommendation', '=', '7 days quarantine')->orWhere('recommendation', '=', '14 days quarantine');
        })->where('status', '=', 1);
    }

    public function health_declaration()
    {
        return $this->hasOne('hrmis\Models\EmployeeHealthCheck', 'employee_id', 'id')->whereDate('date', '=', date('Y-m-d'));
    }

    public function checkVehicle()
    {
        return $this->hasOne('hrmis\Models\Passenger', 'employee_id', 'id')->whereHas('reservation', function($query) {
            $query->where('status', '=', 1)->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'));
        });
    }
}
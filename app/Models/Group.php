<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
	use SoftDeletes;

    protected $fillable 	= ['name', 'alias', 'recommending', 'approval', 'travel_recommending', 'travel_approval', 'hr_approval', 'chief_approval', 'leave_recommending', 'leave_approval', 'offset_recommending', 'offset_approval', 'overtime_recommending', 'overtime_approval', 'location', 'whereabouts', 'is_active'];
	protected $dates 		= ['deleted_at'];

	public function employees()
	{
		return $this->hasMany('hrmis\Models\Employee', 'unit_id', 'id')->where('is_active', '=', 1);
	}

	public function signatories()
	{
		return $this->hasMany('hrmis\Models\SignatoryGroup', 'group_id', 'id');
	}

	public function notification_signatory()
	{
		return $this->hasOne('hrmis\Models\SignatoryGroup', 'group_id', 'id')->whereHas('signatory', function($query) {
			$query->where('module_id', '=', 2)->where('signatory', '=', 'Notification');
		});
	}

	public function offset_notification_signatory()
	{
		return $this->hasOne('hrmis\Models\SignatoryGroup', 'group_id', 'id')->whereHas('signatory', function($query) {
			$query->where('module_id', '=', 3)->where('signatory', '=', 'Notification');
		});
	}

	public function scopeSearch($query, $search)
	{
		return $query->where(function($query) use($search) {
                 $query->where('name', 'like', "%$search%");
             });
	}

	public function scopeEmployees($query, $search)
    {
        return $query->where(function($query) use($search) {
                 $query->whereHas('employees', function($employee) use($search) {
                 	$employee->where('first_name', 'like', "%$search%")->orWhere('middle_name', 'like', "%$search%")->orWhere('last_name', 'like', "%$search%");
                 });
             })->orWhere(function($query) use($search) {
             	$query->where('name', 'like', "%$search%");
             });
    }
}
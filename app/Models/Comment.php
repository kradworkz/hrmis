<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['module', 'module_id', 'comment', 'employee_id'];

    public function employee()
    {
    	return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }

    public function reservation()
    {
        return $this->hasOne('hrmis\Models\Reservation', 'id', 'module');
    }

    public function travel()
    {
        return $this->hasOne('hrmis\Models\Travel', 'id', 'module');
    }

    public function overtime()
    {
        return $this->hasOne('hrmis\Models\OvertimeRequest', 'id', 'module');
    }

    public function tagged()
    {
        return $this->belongsToMany('hrmis\Models\Employee', 'comment_status', 'comment_id', 'employee_id')->withTimestamps();
    }
}
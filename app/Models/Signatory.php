<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class Signatory extends Model
{
    protected $fillable = ['employee_id', 'module_id', 'signatory'];

    public function groups()
    {
    	return $this->belongsToMany('hrmis\Models\Group', 'signatory_groups', 'signatory_id', 'group_id');
    }

    public function module()
    {
    	return $this->hasOne('hrmis\Models\Module', 'id', 'module_id');
    }
    
    public function employee()
    {
    	return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }

    public function group_names()
    {
        $names  = '';
        foreach($this->groups as $group) {
            $names .= $group->alias." ";
        }

        return $names;
    }

    public function scopeModule($query, $module_id)
    {
        if($module_id == "") {
            return null;
        }
        else {
            $query->where('module_id', '=', $module_id);
        }
    }
}
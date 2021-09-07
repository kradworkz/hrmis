<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
	use SoftDeletes;
    protected $fillable = ['plate_number', 'equipment_name', 'code_number', 'model_number', 'serial_number', 'vehicle_type', 'remarks', 'group_id', 'location', 'is_active'];

    public function reservations()
    {
    	return $this->hasMany('hrmis\Models\Reservation', 'vehicle_id', 'id');
    }   

    public function group()
    {
    	return $this->hasOne('hrmis\Models\Group', 'id', 'group_id');
    }

    public function getVehicleNameAttribute()
    {
        return $this->plate_number." ".($this->group ? "(".$this->group->alias.")" : '');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use($search) {
                 $query->where('plate_number', 'like', "%$search%")->orWhere('equipment_name', 'like', "%$search%")->orWhere('model_number', 'like', "%$search%")->orWhere('code_number', 'like', "%$search%");
             });
    }
}
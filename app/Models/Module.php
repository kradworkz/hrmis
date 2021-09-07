<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable 	= ['is_primary', 'is_active'];

    public function signatories()
    {
    	return $this->hasMany('hrmis\Models\Signatory', 'module_id', 'id');
    }

    public function scopeSearch($query, $search)
	{
		return $query->where(function($query) use($search) {
                 $query->where('name', 'like', "%$search%");
             });
	}
}
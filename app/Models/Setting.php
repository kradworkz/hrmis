<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['address', 'recommending', 'recommending_designation', 'approval', 'approval_designation', 'module_id'];

    public function module()
    {
    	return $this->hasOne('hrmis\Models\Module', 'id', 'module_id');
    }
}
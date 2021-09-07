<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class SignatoryGroup extends Model
{
	public function signatory()
	{
		return $this->hasOne('hrmis\Models\Signatory', 'id', 'signatory_id');
	}

	public function scopeModule($query, $module_id, $signatory) {
		$query->whereHas('signatory', function($module) use($module_id, $signatory) {
			$module->where('module_id', '=', $module_id)->where('signatory', '=', $signatory);
		});
	}
}
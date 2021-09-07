<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
	protected $fillable = ['filename', 'title', 'file_path', 'module_type', 'module_id'];

	public function dtr()
	{
		return $this->hasOne('hrmis\Models\Attendance', 'id', 'module_id');
	}
}
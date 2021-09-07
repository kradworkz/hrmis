<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
	protected $table 	= 'push_notifications';
	protected $fillable = ['employee_id', 'recipient_id', 'date_of_birth', 'remarks', 'is_read', 'type'];
	protected $dates 	= ['date_of_birth'];

	public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}

	public function greeting()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'recipient_id');
	}
}
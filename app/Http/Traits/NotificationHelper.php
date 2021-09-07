<?php

namespace hrmis\Http\Traits;

use Auth, Carbon\Carbon;
use hrmis\Models\Travel;
use hrmis\Models\Offset;
use hrmis\Models\Module;
use hrmis\Models\Comment;
use hrmis\Models\Employee;
use hrmis\Models\Signatory;
use hrmis\Models\Attendance;
use hrmis\Models\Reservation;
use hrmis\Models\Notification;
use hrmis\Models\CommentStatus;
use hrmis\Models\OvertimeRequest;

trait NotificationHelper
{
	public function newNotification($employees, $reference_id, $type, $route, $action)
	{
		$now    = Carbon::now()->toDateTimeString();
		$data 	= array();
		if(count($employees)) {
			foreach($employees as $employee) {
				$data[] = array(
					'sender_id' 		=> Auth::id(),
					'recipient_id' 		=> $employee,
					'reference_id' 		=> $reference_id,
					'type' 				=> $type,
					'parameters'		=> $route,
					'action' 			=> $action,
					'created_at' 		=> $now,
					'updated_at' 		=> $now,
				);
			}
			Notification::insert($data);
		}
	}
}
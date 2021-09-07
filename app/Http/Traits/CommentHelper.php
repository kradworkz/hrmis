<?php

namespace hrmis\Http\Traits;

use Auth, Carbon\Carbon;
use hrmis\Models\Leave;
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
use hrmis\Models\EmployeeQuarantine;

trait CommentHelper
{
	public function submitComment($id, $module_id)
	{
        $user_comment = \Request::get('comment');
        if($user_comment != "") {
            $module     = Module::find($module_id);
            
            if($module->name == 'Vehicle Reservation') {
                $route  = 'View Reservation';
                $model  = Reservation::find($id);
            }
            elseif($module->name == 'Travel Order') {
                $route  = 'View Travel Order';
                $model  = Travel::find($id);
            }
            elseif($module->name == 'Offset') {
                $route  = 'Edit Offset';
                $model  = Offset::find($id);
            }
            elseif($module->name == 'Overtime Request') {
                $route  = 'View Overtime Request';
                $model  = OvertimeRequest::find($id);
            }
            elseif($module->name == 'Attendance') {
                $route  = 'Edit Daily Time Record';
                $model  = Attendance::withoutGlobalScopes()->find($id);
            }
            elseif($module->name == 'Leave') {
                $route  = 'Edit Leave';
                $model  = Leave::find($id);
            }
            elseif($module->name == 'Health Check') {
                $model  = EmployeeQuarantine::find($id);
            }

            $now        = Carbon::now()->toDateTimeString();
            $data       = array();

            foreach($model->tagged_employees() as $employee) {
                $data[] = array(
                    'sender_id'     => Auth::id(),
                    'recipient_id'  => $employee->id,
                    'reference_id'  => $model->id,
                    'type'          => $module->name,
                    'parameters'    => $employee->route ? $employee->route : $route,
                    'action'        => 'Comment',
                    'created_at'    => $now,
                    'updated_at'    => $now,       
                );
            }

            Notification::insert($data);

            $comment                = new Comment;
            $comment->module        = $id;
            $comment->module_id     = $module_id;
            $comment->comment       = $user_comment;
            $comment->employee_id   = Auth::id();
            $comment->save();
        }
	}
}
<?php

namespace hrmis\Http\Traits;

use Auth;
use hrmis\Models\Travel;
use hrmis\Models\Offset;
use hrmis\Models\Employee;
use hrmis\Models\Signatory;
use hrmis\Models\Reservation;
use hrmis\Models\ApprovalStatus;
use hrmis\Models\OvertimeRequest;

trait ApprovalStatusHelper
{
	public function submitAction($id, $module_id, $action)
	{
		$approval 				= new ApprovalStatus;
		$approval->module 		= $id;
		$approval->module_id 	= $module_id;
		$approval->employee_id 	= Auth::id();
		$approval->action 		= $action;
		
		if($approval->save()){
			if($module_id == 1){
				$title = "Vehicle Reservation";
				$data = Reservation::where('id',$id)->first();
				$name = $data->employee->first_name.' '.$data->employee->middle_name.' '.$data->employee->last_name;
				$contact = $data->employee->contact_no;
				$purpose = $data->purpose;
			}else if($module_id == 2){
				$title = "Travel Order";
				$data = Travel::where('id',$id)->first();
				$name = $data->employee->first_name.' '.$data->employee->middle_name.' '.$data->employee->last_name;
				$contact = $data->employee->contact_no;
				$purpose = $data->purpose;
			}else{
				// pending
			}

			if($action == 1){
				$text = "Hi, ".$name.", Your ".$title." has been Approved. (".$purpose.")";
				$this->sms($text,$title,$contact);
			}else if($action == 2){
				$text = "Hi, ".$name.", Your ".$title." has been Rejected. (".$purpose.")";
				$this->sms($text,$title,$contact);
			}else{
				// pending
			}
		}
	}

	public function sms($text,$title,$contact){
		if($contact != null){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.dost9.ph/sms/messages');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$post = array(
				'recipient' => $contact,
				'message' => $text,
				'title' => $title
			);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close($ch);
		}
	}
}
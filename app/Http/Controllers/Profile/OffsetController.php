<?php

namespace hrmis\Http\Controllers\Profile;

use Auth, URL;
use Carbon\Carbon;
use hrmis\Models\Offset;
use hrmis\Models\Employee;
use hrmis\Models\Attachment;
use hrmis\Models\EmployeeCOC;
use hrmis\Models\Notification;
use hrmis\Models\ApprovalStatus;
use hrmis\Http\Controllers\Profile\Controller;
use hrmis\Http\Requests\OffsetValidation;
use hrmis\Http\Traits\CommentHelper;
use Illuminate\Http\Request;

class OffsetController extends Controller
{
	use CommentHelper;

	public function index(Request $request)
	{
		$id 			= 0;
		$year 			= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 			= $request->get('month') == null ? date('m') : $request->get('month');

		$years 			= config('app.years');
		$months 		= config('app.months');
		$route 			= 'Offset';
		
		$offset 		= Offset::where('employee_id', '=', Auth::id())->year($year)->month($month)->orderBy('date', 'desc')->get();
		return view('profile.offset.offset', compact('id', 'offset', 'year', 'years', 'route', 'month', 'months'));
	}
	
	public function new()
	{
		$id 		= 0;
		$offset 	= new Offset;
		$time       = array('8:00 to 5:00' => '8:00 to 5:00', '8:00 to 12:00' => '8:00 to 12:00', '1:00 to 5:00' => '1:00 to 5:00');
		return view('profile.offset.form', compact('id', 'offset', 'time'));
	}

	public function edit($id)
	{
		$offset 	= Offset::find($id);
		$time       = array('8:00 to 5:00' => '8:00 to 5:00', '8:00 to 12:00' => '8:00 to 12:00', '1:00 to 5:00' => '1:00 to 5:00');
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Offset')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('profile.offset.form', compact('id', 'offset', 'time'));
	}

	public function view($id)
	{
		$offset 	= Offset::find($id);
		$time       = array('8:00 to 5:00' => '8:00 to 5:00', '8:00 to 12:00' => '8:00 to 12:00', '1:00 to 5:00' => '1:00 to 5:00');
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Offset')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('profile.offset.view', compact('id', 'offset', 'time'));
	}

	public function status($id)
	{
		$approvals 		= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 3)->get();
		return view('layouts.status', compact('id', 'approvals'));
	}

	public function cancel($id)
	{
		$offset    			= Offset::find($id);
		$coc 				= EmployeeCOC::where('offset_id', '=', $id)->delete();
		$offset->delete();
		return redirect(URL::previous())->with('message', 'Offset successfully deleted.')->with('alert', 'alert-success');
	}

	public function submit(OffsetValidation $request, $id)
	{
		$alert_success = 'alert-success';
		$alert_update = 'alert-info';
		$alert_fail = 'alert-danger';
		$success_msg = 'New offset successfully added.';
		$update_msg = 'Offset successfully updated.';
		$fail_msg = 'You do not have enough compensatory overtime credits.';

		$balance 	= Auth::user()->employee_balance();
		$date  		= Carbon::parse($request->get('date'));
		$hours 		= $request->get('time') == '8:00 to 5:00' ? 8 : 4;
		$request->request->add(['employee_id' 		=> Auth::id()]);
		$request->request->add(['hours' 			=> $hours]);

		if(Auth::user()->unit->offset_recommending == 0) {
			$request->request->add(['recommending' => 1]);
			$request->request->add(['recommending_by' => Auth::id()]);
		}

		if(Auth::user()->unit->notification_signatory == null) {
			$request->request->add(['checked' 		=> 1]);
			$request->request->add(['checked_by' 	=> Auth::id()]);
		}

		if($request->has('is_positive') && $request->get('is_positive') == 1) {
			if($id == 0) {
				$alert = $alert_success;
	            $message = $success_msg;
				$offset = $this->createOffsetRecord($request);
			}
			else {
				$alert = $alert_update;
	            $message = $update_msg;
	            $offset = $this->updateOffsetRecord($id, $request);
			}

			if($request->has('attachments')) {
				$file 				= $request->file('attachments');
				$filename 			= $file->hashName();
				$path 				= $file->storeAs('attachments', $filename, 'dost');
				$attachment 		= Attachment::create([
					'module_id' 	=> $offset->id,
					'module_type' 	=> 3,
					'filename' 		=> $filename,
					'title' 		=> $file->getClientOriginalName(),
					'file_path' 	=> $path,
				]);
			}
			$this->submitComment($id == 0 ? $offset->id : $id, 3);
		}
		else {
			if($balance < $hours*60) {
				$alert = $alert_fail;
				$message = $fail_msg;
			}
			else {
				if($id == 0) {
					$alert = $alert_success;
	            	$message = $success_msg;
					$offset = $this->createOffsetRecord($request);

					$coc 					= new EmployeeCOC;
					$coc->employee_id 		= Auth::id();
					$coc->offset_id 		= $offset->id;
					$coc->offset_hours 		= $hours;
					$coc->end_hours 		= Auth::user()->employee_coc->end_hours-$hours;
					$coc->end_minutes 		= Auth::user()->employee_coc->end_minutes;
					$coc->month 			= $date->format('m');
					$coc->year 				= $date->format('Y');
					$coc->type 				= 0;
					$coc->latest_balance 	= 1;
					$coc->save();
				}
				else {
					$alert = $alert_update;
		            $message = $update_msg;
		            $offset = $this->updateOffsetRecord($id, $request);

		            $coc 					= EmployeeCOC::where('offset_id', '=', $id)->first();
		            $coc->offset_id 		= $offset->id;
		            $coc->offset_hours 		= $offset->hours;
		            $coc->month 			= $date->format('m');
					$coc->year 				= $date->format('Y');
		            $coc->type 				= 0;
		            $coc->latest_balance 	= 1;
		            $coc->update();
				}
				$this->submitComment($id == 0 ? $offset->id : $id, 3);
			}
		}

		return redirect()->route('Offset')->with('message', $message)->with('alert', $alert);
	}

	public function createOffsetRecord($request)
	{
		$offset = Offset::create($request->all());
		return $offset;
	}

	public function updateOffsetRecord($id, $request)
	{
		$offset = Offset::find($id);
	    $offset->update($request->all());
	    return $offset;
	}
}
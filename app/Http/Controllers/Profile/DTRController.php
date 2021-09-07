<?php

namespace hrmis\Http\Controllers\Profile;

use Auth, URL;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Employee;
use hrmis\Models\Attachment;
use hrmis\Models\Attendance;
use hrmis\Models\Notification;
use hrmis\Http\Controllers\Profile\Controller;
use hrmis\Http\Requests\DTRValidation;
use hrmis\Http\Traits\CommentHelper;
use Illuminate\Http\Request;

class DTRController extends Controller
{
	use CommentHelper;

	public function index(Request $request)
	{
		$start_date 	= $request->get('start_date');
		$end_date 		= $request->get('end_date');

		if($start_date == null && $end_date == null) {
			$start_date = Carbon::createFromDate(date('Y'), date('m'), 1)->firstOfMonth();
			$end_date 	= Carbon::createFromDate(date('Y'), date('m'), 1)->lastOfMonth();
		}
		else {
			$start_date = Carbon::parse($request->get('start_date'));
			$end_date 	= Carbon::parse($request->get('end_date'));
		}

		$attachments 	= true;
		$print_dtr 		= true;

		// $year 			= $request->get('year') == null ? date('Y') : $request->get('year');
		// $month 			= $request->get('month') == null ? date('m') : $request->get('month');

		// $start_date 		= Carbon::createFromDate($year, $month, 1)->firstOfMonth();
		// $end_date 		= Carbon::createFromDate($year, $month, 1)->lastOfMonth();

		$days 			= CarbonPeriod::create($start_date, $end_date);

		// $years 			= config('app.years');
		// $months 			= config('app.months');
		// $months 			= array_except($months, "00");

		$route 			= 'Daily Time Record';

		$working_days 	= 0;
		$biometrics 	= 0;
		$travel_count 	= 0;
		$offset_count 	= 0;
		$coc_earned 	= 0;
		$late_count 	= 0;
		$dtr 			= Attendance::where('employee_id', '=', Auth::id())->whereBetween('time_in', [$start_date, $end_date])->orderBy('time_in')->get();
		$pending_dtr 	= Attendance::withoutGlobalScopes()->where('status', '=', 0)->where('updated_by', '!=', NULL)->where('employee_id', '=', Auth::id())->get();
		return view('profile.dtr.dtr', compact('route', 'days', 'pending_dtr', 'working_days', 'travel_count', 'offset_count', 'biometrics', 'coc_earned', 'late_count', 'attachments', 'print_dtr', 'start_date', 'end_date', 'dtr'));
	}

	public function new()
	{
		$id 			= 0;
		$dtr 			= new Attendance;
		return view('profile.dtr.form', compact('id', 'dtr'));
	}

	public function edit($id)
	{
		$dtr 			= Attendance::withoutGlobalScopes()->where('status', '=', 0)->find($id);
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Attendance')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('profile.dtr.form', compact('id', 'dtr'));
	}

	public function view($id)
	{
		$dtr 			= Attendance::withoutGlobalScopes()->find($id);
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Attendance')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('profile.dtr.view', compact('id', 'dtr'));
	}

	public function delete($id)
	{
		$dtr    		= Attendance::withoutGlobalScopes()->find($id);
		$dtr->delete();
		return redirect(URL::previous())->with('message', 'DTR successfully deleted.')->with('alert', 'alert-success');
	}

	public function search($date)
	{
		$dtr = Attendance::whereDate('time_in', $date)->where('employee_id', Auth::id())->first();
		if($dtr) {
			return json_encode(array(
				'time_in' 	=> optional($dtr->time_in)->format('H:i'),
				'time_out' 	=> optional($dtr->time_out)->format('H:i')
			));
		}
		else {
			return 0;
		}
	}

	public function submit(DTRValidation $request, $id)
	{
		$date 			= $request->get('date');
		$request->request->add(['employee_id' 	=> Auth::id()]);
		$request->request->add(['status' 		=> 0]);
		$request->request->add(['updated_by' 	=> Auth::id()]);
		$request->request->add(['time_in' 		=> $request->get('time_in') != null ? ($date." ".$request->get('time_in')).":".date('s') : null]);
		$request->request->add(['time_out' 		=> $request->get('time_out') != null ? ($date." ".$request->get('time_out')).":".date('s') : null]);

		if($id == 0) {
			$alert      	= 'alert-success';
		    $message    	= 'Daily Time Record successfully added.';
		    $dtr   			= Attendance::create($request->all());
		}
		else {
			$alert      	= 'alert-info';
		    $message    	= 'Daily Time Record successfully updated.';
		    $dtr   			= Attendance::withoutGlobalScopes()->where('status', '=', 0)->find($id);
		    $dtr->update($request->all());
		}

		if($request->hasFile('attachments')) {
			$file 				= $request->file('attachments');
			$filename 			= $file->hashName();
			$path 				= $file->storeAs('attachments', $filename, 'dost');
			$attachment 		= Attachment::create([
				'module_id' 	=> $dtr->id,
				'module_type' 	=> 5,
				'filename' 		=> $filename,
				'title' 		=> $file->getClientOriginalName(),
				'file_path' 	=> $path,
			]);
        }

		$this->submitComment($id == 0 ? $dtr->id : $id, 5);
		return redirect()->route('Daily Time Record')->with('message', $message)->with('alert', $alert);
	}
}
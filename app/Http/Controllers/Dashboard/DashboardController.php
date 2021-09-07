<?php

namespace hrmis\Http\Controllers\Dashboard;

use Auth;
use Carbon\Carbon;
use hrmis\Models\Travel;
use hrmis\Models\Offset;
use hrmis\Models\Employee;
use hrmis\Models\LeaveDate;
use hrmis\Models\Attendance;
use hrmis\Models\Reservation;
use hrmis\Models\TravelPassenger;
use hrmis\Models\ModeOfConveyance;
use hrmis\Models\PersonalInformation;
use hrmis\Models\EmployeeHealthCheck;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function index(Request $request)
	{
		$date 		 = $request->get('date') == null ? date('Y-m-d') : $request->get('date');
		$employees 	 = Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		$travels 	 = TravelPassenger::whereHas('travels', function($query) use($date) {
			$query->where('is_active', '=', 1)->whereDate('start_date', '=', $date)->orWhereDate('end_date', '=', $date);
		})->get();
		$vehicles 	 = Reservation::where('is_active', '=', 1)->whereDate('start_date', '=', $date)->orWhereDate('end_date', '=', $date)->get();
		$offset 	 = Offset::where('is_active', '=', 1)->whereDate('date', '=', $date)->get();
		$leave 		 = LeaveDate::whereDate('date', '=', $date)->get();
		$wfh 		 = Attendance::selectRaw('*, MIN(time_in) as time_in, MAX(time_out) as time_out')->where('location', '=', 0)->whereDate('time_in', '=', $date)->groupBy('employee_id')->orderBy('time_in')->get();
		$office 	 = Attendance::selectRaw('*, MIN(time_in) as time_in, MAX(time_out) as time_out')->where('location', '=', 1)->whereDate('time_in', '=', $date)->groupBy('employee_id')->orderBy('time_in')->get();
		$male 		 = PersonalInformation::where('gender', '=', 'Male')->count();
		$female 	 = PersonalInformation::where('gender', '=', 'Female')->count();
		$cos 		 = Employee::where('is_active', '=', 1)->where('employee_status_id', '=', 1)->count();
		$permanent 	 = Employee::where('is_active', '=', 1)->where('employee_status_id', '=', 3)->count();
		return view('dashboard.dashboard', compact('employees', 'travels', 'date', 'vehicles', 'offset', 'male', 'female', 'cos', 'permanent', 'wfh', 'office', 'leave'));
	}

	public function reservation($id)
	{
		$reservation = Reservation::find($id);
		return view('dashboard.reservation', compact('id', 'reservation'));
	}

	public function travel($id)
	{
		$travel 	 = Travel::find($id);
		return view('dashboard.travels', compact('id', 'travel'));
	}

	public function desktop_time_in(Request $request, $id)
	{
        $emp = Employee::find($id);
        if (!$emp) return '0';

        $date =  date("Y-m-d");

        $where = "(employee_id = ?) AND (DATE_FORMAT(time_in, '%Y-%m-%d') = ?) AND (ISNULL(time_out))";
        $values = array();
        $values[] = $id;
        $values[] = $date;

        $row = Attendance::whereRaw($where, $values)->first();
        if (!$row){
            $row = new Attendance();
            $row->employee_id = $id;
            $row->time_in = date("Y-m-d H:i:s");
            $row->time_out = NULL;
            $row->ip_address = $request->getClientIp();
        } else {
            $row->time_out = date("Y-m-d H:i:s");
            $row->ip_address = $request->getClientIp();
        }
        $row->save();

        return redirect()->back();
    }

	public function submit_health_check(Request $request, $id)
	{
		$request->request->add(['employee_id' => Auth::id()]);
		$request->request->add(['date' 		  => date('Y-m-d')]);
		$health_check 	= EmployeeHealthCheck::create($request->except(['work_location', 'mode_of_conveyance', 'remarks']));

		if($request->get('work_location') == 1) {
			$mode = new ModeOfConveyance;
			$mode->employee_id = Auth::id();
			$mode->mode_of_conveyance = $request->get('mode_of_conveyance');
			$mode->remarks = $request->get('remarks');
			$mode->save();
		}

		return redirect()->route('Dashboard')->with('message', 'Health Declaration successfully submitted')->with('alert', 'alert-success');
	}

	public function time_out(Request $request, $id)
	{
		$date 	  	= date('Y-m-d');
		$values 	= array();
        $values[] 	= $id;
        $values[] 	= $date;
        $where 		= "(employee_id = ?) AND (DATE_FORMAT(time_in, '%Y-%m-%d') = ?) AND (ISNULL(time_out))";
		$attendance = Attendance::whereRaw($where, $values)->first();
		
		if($attendance) {
			$attendance->time_out 	= date("Y-m-d H:i:s");
			$attendance->ip_address = $request->getClientIp();
			$attendance->save();
			return redirect()->route('Dashboard')->with('message', 'Time Out successfully submitted')->with('alert', 'alert-success');
		}
	}
}
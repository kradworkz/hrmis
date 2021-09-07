<?php

namespace hrmis\Http\Controllers\HR;

use URL;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Vehicle;
use hrmis\Models\Employee;
use hrmis\Models\Reservation;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
	public function index(Request $request)
	{
		$vehicle_id 	= $request->get('vehicle_id');

		$year 			= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 			= $request->get('month') == null ? date('m') : $request->get('month');

		$years 			= config('app.years');
		$months 		= config('app.months');

		$search  		= $request->get('search') == null ? '' : $request->get('search');
		$vehicles 		= Vehicle::where('is_active', '=', 1)->get();
		$reservations 	= Reservation::active()->vehicle($vehicle_id)->year($year)->month($month)->search($search)->orderBy('created_at', 'desc')->paginate(100);
		return view('hr.reservations.reservations', compact('reservations', 'vehicles', 'vehicle_id', 'years', 'year', 'months', 'month'));
	}
}
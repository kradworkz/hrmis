<?php

namespace hrmis\Http\Controllers\Calendar;

use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use hrmis\Models\Offset;
use hrmis\Models\Travel;
use hrmis\Models\Vehicle;
use hrmis\Models\Reservation;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
	public function vehicle_index(Request $request)
	{
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 		= $request->get('month') == null ? date('m') : $request->get('month');
		$years 		= config('app.years');
		$months 	= config('app.months');
		$view 		= $request->get('view') == null ? 'List' : $request->get('view');
		$date 		= $request->get('date') ? Carbon::parse($request->get('date')) : Carbon::now();
		$tagged 	= $request->get('tagged');
		$vehicle_id = $request->get('vehicle_id');
		// dd($date);	
		$start_date = Carbon::createFromDate($year, $month, 1)->firstOfMonth(1);
		$end_date 	= Carbon::createFromDate($year, $month, 1)->lastOfMonth();

		$first 		= Carbon::createFromDate($year, $month, 1)->firstOfMonth()->format('l');

		if($request->has('start_date') && $request->has('end_date')) {
			$start_date = Carbon::parse($request->get('start_date'));
			$end_date 	= Carbon::parse($request->get('end_date'));
		}
		else {
			$start_date = Carbon::createFromDate($year, $month, 1)->firstOfMonth(1);
			$end_date 	= Carbon::createFromDate($year, $month, 1)->lastOfMonth();
		}

		$range 			= CarbonPeriod::create(Carbon::createFromDate($year, $month, 1)->firstOfMonth(), Carbon::createFromDate($year, $month, 1)->lastOfMonth());
		$remainder 		= CarbonPeriod::create(Carbon::createFromDate($year, $month, 1)->firstOfMonth(), Carbon::createFromDate($year, $month, 1)->firstOfMonth(0));
		$headers 		= array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Satuday', 'Sunday');
		$days 			= CarbonPeriod::create($start_date, $end_date);
		
		if($view == 'Calendar') {
			$vehicles 		= Vehicle::with(['reservations' => function($query) use($start_date, $end_date) {
				$query->whereBetween('start_date', [$start_date, $end_date])->orderBy('start_date');
			}])->where('is_active', '=', 1)->get();

			$reservations 	= Reservation::where('is_active', '=', 1)->whereBetween('start_date', [Carbon::createFromDate($year, $month, 1)->firstOfMonth(), $end_date])->orderBy('start_date', 'desc')->orderBy('vehicle_id', 'asc')->orderBy('created_at', 'desc')->get();
		}
		else {
			$vehicles 		= Vehicle::where('is_active', '=', 1)->orderBy('created_at', 'asc')->get();
    		$reservations 	= Reservation::where('is_active', '=', 1)->vehicle($vehicle_id)->tagged($tagged)->filter(null, $date, $date->format('Y'), $date->format('m'))->orderBy('start_date')->get();
		}

		return view('calendar.vehicles', compact('vehicles', 'month', 'months', 'year', 'years', 'start_date', 'end_date', 'days', 'reservations', 'headers', 'remainder', 'first', 'range', 'view', 'date', 'tagged', 'vehicle_id'));
	}

	public function offset_index(Request $request)
	{
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 		= $request->get('month') == null ? date('m') : $request->get('month');

		$years 		= config('app.years');
		$months 	= config('app.months');

		$start_date = Carbon::createFromDate($year, $month, 1)->firstOfMonth(1);
		$end_date 	= Carbon::createFromDate($year, $month, 1)->lastOfMonth();

		$first 		= Carbon::createFromDate($year, $month, 1)->firstOfMonth()->format('l');

		if($request->has('start_date') && $request->has('end_date')) {
			$start_date = Carbon::parse($request->get('start_date'));
			$end_date 	= Carbon::parse($request->get('end_date'));
		}
		else {
			$start_date = Carbon::createFromDate($year, $month, 1)->firstOfMonth(1);
			$end_date 	= Carbon::createFromDate($year, $month, 1)->lastOfMonth();
		}

		$remainder 		= CarbonPeriod::create(Carbon::createFromDate($year, $month, 1)->firstOfMonth(), Carbon::createFromDate($year, $month, 1)->firstOfMonth(0));
		$headers 		= array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Satuday', 'Sunday');
		$days 			= CarbonPeriod::create($start_date, $end_date);

		$offset 		= Offset::where('is_active', '=', 1)->whereMonth('date', '=', $month)->whereYear('date', '=', $year)->get();
		return view('calendar.offset', compact('offset', 'month', 'months', 'year', 'years', 'start_date', 'end_date', 'days', 'headers', 'remainder', 'first'));
	}

	public function travel_index(Request $request)
	{
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 		= $request->get('month') == null ? date('m') : $request->get('month');

		$years 		= config('app.years');
		$months 	= config('app.months');

		$start_date = Carbon::createFromDate($year, $month, 1)->firstOfMonth(1);
		$end_date 	= Carbon::createFromDate($year, $month, 1)->lastOfMonth();

		$first 		= Carbon::createFromDate($year, $month, 1)->firstOfMonth()->format('l');

		if($request->has('start_date') && $request->has('end_date')) {
			$start_date = Carbon::parse($request->get('start_date'));
			$end_date 	= Carbon::parse($request->get('end_date'));
		}
		else {
			$start_date = Carbon::createFromDate($year, $month, 1)->firstOfMonth(1);
			$end_date 	= Carbon::createFromDate($year, $month, 1)->lastOfMonth();
		}

		$remainder 		= CarbonPeriod::create(Carbon::createFromDate($year, $month, 1)->firstOfMonth(), Carbon::createFromDate($year, $month, 1)->firstOfMonth(0));
		$headers 		= array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Satuday', 'Sunday');
		$days 			= CarbonPeriod::create($start_date, $end_date);

		$travels 		= Travel::where('is_active', '=', 1)->whereBetween('start_date', [Carbon::createFromDate($year, $month, 1)->firstOfMonth(), $end_date])->orderBy('start_date', 'desc')->get();
		return view('calendar.travels', compact('travels', 'month', 'months', 'year', 'years', 'start_date', 'end_date', 'days', 'headers', 'remainder', 'first'));
	}

	public function vehicle_schedule($id, $date)
	{
		$reservations = Reservation::active()->where('vehicle_id', '=', $id)->whereRaw('"'.$date.'" between `start_date` and `end_date`')->get();

		if(count($reservations) == 1) {
			$reservation = $reservations->first();
			$id 		 = $reservation->id;
			return view('dashboard.reservation', compact('id', 'reservation'));
		}
		else {
			return view('calendar.vehicles_view', compact('reservations'));
		}
	}
}
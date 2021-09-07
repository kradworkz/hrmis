<?php

namespace hrmis\Http\Controllers\Profile;

use Auth, Carbon\Carbon, URL;
use Carbon\CarbonPeriod;
use hrmis\Models\Travel;
use hrmis\Models\Vehicle;
use hrmis\Models\Employee;
use hrmis\Models\Passenger;
use hrmis\Models\Reservation;
use hrmis\Models\Notification;
use hrmis\Models\ApprovalStatus;
use hrmis\Models\TravelDocument;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Traits\NotificationHelper;
use hrmis\Http\Controllers\Profile\Controller;
use hrmis\Http\Requests\ReservationValidation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
	use CommentHelper, NotificationHelper;

	public function index(Request $request)
	{
		$id 			= 0;
		$year 			= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 			= $request->get('month') == null ? date('m') : $request->get('month');
		$search 		= $request->get('search') == null ? '' : $request->get('search');
		$years 			= config('app.years');
		$months 		= config('app.months');
		$route 			= 'Vehicle Reservation';
		
		$reservations 	= Reservation::tagged(Auth::id())->search($search)->year($year)->month($month)->orderBy('start_date', 'desc')->paginate(50);
		return view('profile.reservations.reservations', compact('id', 'reservations', 'year', 'years', 'route', 'months', 'month', 'search'));
	}

	public function new()
	{
		$id 		 	= 0;
		$reservation 	= new Reservation;
		$vehicles 	 	= Vehicle::where('is_active', '=', 1)->get();
		$employees 	 	= Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		return view('profile.reservations.form', compact('id', 'reservation', 'employees', 'vehicles'));
	}

	public function edit($id)
	{
		$reservation 	= Reservation::find($id);
		$vehicles 	 	= Vehicle::where('is_active', '=', 1)->get();
		$employees 	 	= Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		return view('profile.reservations.form', compact('id', 'reservation', 'employees', 'vehicles'));
	}

	public function tag($id, $employee_id = null)
	{
		$reservation    = Passenger::where('reservation_id', '=', $id)->where('employee_id', '=', $employee_id == null ? Auth::id() : $employee_id)->delete();
		return redirect(URL::previous())->with('message', 'Reservation Tag successfully removed.')->with('alert', 'alert-success');
	}

	public function delete($id)
	{
		$reservation    = Reservation::find($id);
		$reservation->delete();
		return redirect(URL::previous())->with('message', 'Reservation successfully removed.')->with('alert', 'alert-success');
	}

	public function view($id)
	{
		$reservation 	= Reservation::find($id);
		$vehicles 	 	= Vehicle::where('is_active', '=', 1)->get();
		$employees 		= Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Vehicle Reservation')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('profile.reservations.view', compact('id', 'reservation', 'employees', 'vehicles'));
	}

	public function status($id)
	{
		$approvals 		= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 1)->get();
		return view('layouts.status', compact('id', 'approvals'));
	}

	public function vehicles()
	{
		$vehicles 		= "s";
		$start 			= \Request::get('start_date');
		$end 			= \Request::get('end_date');
		$start_date 	= Carbon::parse(\Request::get('start_date'));
		$end_date 		= Carbon::parse(\Request::get('end_date'));
		$van_rental 	= Vehicle::where('plate_number', '=', 'Van Rental')->first();
		if(($start != "" && $end != "")) {
			if($end_date->gte($start_date)) {
				$reservations 	= Reservation::where('status', '=', 1)->whereHas('vehicle', function($query) {
					$query->where('plate_number', '!=', 'Van Rental');
				})->where(function($query) use($start_date, $end_date) {
					$query->where('start_date', '<=', $start_date->format('Y-m-d'))->where('end_date', '>=', $start_date->format('Y-m-d'));
				})->orWhere(function($query) use($start_date, $end_date) {
					$query->where('end_date', '<=', $start_date->format('Y-m-d'))->where('start_date', '>=', $start_date->format('Y-m-d'));
				})->pluck('vehicle_id');
				$vehicles = Vehicle::with('group')->where('is_active', '=', 1)->whereNotIn('id', $reservations)->get();
				if(!$vehicles->contains('plate_number', 'Van Rental')) {
					$vehicles->push($van_rental);
				}
			}
		}

		return $vehicles;
	}

	public function submit(ReservationValidation $request, $id)
	{
		$vehicle 		= Vehicle::find($request->get('vehicle_id'));
		$passengers 	= $request->get('passengers');

		if(!$request->has('location')) {
			$request->request->add(['location' 	=> 0]);
		}
		if($vehicle->location == 0) {
			$request->request->add(['status' 	=> 1]);
		}

		$request->request->add(['employee_id' 	=> Auth::id()]);
		$request->request->add(['is_pd' 		=> Auth::user()->is_pd() ? 1 : 0]);
		
		if($id == 0) {
			$alert          = 'alert-success';
            $message        = 'New reservation successfully added.';
            $reservation    = Reservation::create($request->all());
            $notif_tags 	= $passengers;
            $reservation->passengers()->attach($request->get('passengers'));
            if($request->get('travel_order') == 'on') {
            	$this->create_travel_order($request, $reservation);
	 		}
		}
		else {
			$alert          = 'alert-info';
            $message        = 'Reservation successfully updated.';
            $reservation    = Reservation::find($id);
            $notif_tags 	= array_diff($passengers, $reservation->passengers->pluck('id')->toArray());
            $reservation->update($request->all());
            $reservation->passengers()->sync($request->get('passengers'));
 		}

 		$this->submitComment($id == 0 ? $reservation->id : $id, 1);
 		$this->newNotification($notif_tags, $reservation->id, 'Vehicle Reservation', 'View Reservation', 'Tag');
		return redirect()->route('Vehicle Reservation')->with('message', $message)->with('alert', $alert);
	}

	function create_travel_order($request, $reservation)
	{
		$checked = null;
		$checked_by = null;

		if(Auth::user()->unit->notification_signatory == null) {
			$checked = 1;
			$checked_by = Auth::id();
		}

		$travel_fund_expenses = [];
		if($request->get('expense_id')) {
			foreach($request->get('expense_id') as $expenses) {
				$travel_fund_expenses[] = ['fund_id' => explode(',', $expenses)[1], 'expense_id' => explode(',', $expenses)[0]];
			}
		}

		$travel 				= new Travel;
		$travel->employee_id 	= Auth::id();
		$travel->start_date 	= $request->get('start_date');
		$travel->end_date 		= $request->get('end_date');
		$travel->mode_of_travel = $reservation->vehicle->plate_number == 'Van Rental' ? 'Van Rental' : 'DOST Vehicle';
		$travel->purpose 		= $request->get('purpose');
		$travel->destination 	= $request->get('destination');
		$travel->time 			= $request->get('time');
		$travel->time_mode 		= 'Whole Day';
		$travel->checked 		= $checked;
		$travel->checked_by 	= $checked_by;
		$travel->save();
		$travel->travel_passengers()->attach($request->get('passengers'));
		$travel->travel_funds_expenses()->attach($travel_fund_expenses);
		if($request->hasFile('document_path')) {
            foreach($request->file('document_path') as $document) {
                $filename   = $document->hashName();
                $path       = $document->storeAs('travel_documents', $filename, 'dost');
                TravelDocument::create([
                    'travel_id'     => $travel->id,
                    'filename'      => $filename,
                    'title'         => $document->getClientOriginalName(),
                    'document_path' => $path,
                ]);
            }
        }
        $this->newNotification($request->get('passengers'), $travel->id, 'Travel Order', 'View Travel Order', 'Tag');
	}
}
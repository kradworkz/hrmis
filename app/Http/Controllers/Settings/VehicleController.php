<?php

namespace hrmis\Http\Controllers\Settings;

use Auth;
use hrmis\Models\Group;
use hrmis\Models\Vehicle;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
	public function index(Request $request)
	{
		$search 		= $request->get('search') == null ? '' : $request->get('search');
		$route 			= 'Vehicles';
		$vehicles 		= Vehicle::search($search)->get();
		return view('settings.vehicles.vehicles', compact('vehicles', 'route', 'search'));
	}
	
	public function new()
	{
		$id 		= 0;
		$groups 	= Group::select('id', 'name')->where('is_active', '=', 1)->get();
		$vehicle 	= new Vehicle;
		return view('settings.vehicles.form', compact('id', 'vehicle', 'groups'));
	}

	public function edit($id)
	{
		$groups 	= Group::select('id', 'name')->where('is_active', '=', 1)->get();
		$vehicle 	= Vehicle::find($id);
		return view('settings.vehicles.form', compact('id', 'vehicle', 'groups'));
	}

	public function submit(Request $request, $id)
	{
		if($id == 0) {
			$alert 		= 'alert-success';
			$message 	= 'New vehicle successfully added.';
			Vehicle::create($request->all());
		}
		else {
			$alert 		= 'alert-info';
			$message 	= 'Vehicle successfully updated.';
			$vehicle 	= Vehicle::find($id);
			$vehicle->update($request->all());
 		}
		return redirect()->route('Vehicles')->with('message', $message)->with('alert', $alert);
	}
}
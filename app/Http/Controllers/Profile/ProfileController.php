<?php

namespace hrmis\Http\Controllers\Profile;

use Auth, URL;
use hrmis\Models\Role;
use hrmis\Models\Group;
use hrmis\Models\Employee;
use hrmis\Models\EmployeeStatus;
use hrmis\Http\Requests\ProfileValidation;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProfileController extends Controller
{
	public function index()
	{
		$employee 	= Auth::user();
		return view('profile.profile.profile', compact('employee'));
	}

	public function submit(ProfileValidation $request)
	{
		$alert 		= 'alert-success';
		$message 	= 'Profile successfully updated.';
		$employee 	= Employee::find(Auth::id());
		$employee->touch();
		$employee->update(array_filter($request->all()));

		if($request->hasFile('picture')) {
            $request->file('picture')->storeAs('public/profile', $employee->username.".".$request->file('picture')->getClientOriginalExtension());
            $employee->picture  = $employee->username.".".$request->file('picture')->getClientOriginalExtension();
            $employee->save();
        }
        if($request->hasFile('signature')) {
            $filename = $employee->username.".".$request->file('signature')->getClientOriginalExtension();
            $request->file('signature')->storeAs('employee_signature', $employee->username.".".$request->file('signature')->getClientOriginalExtension(), 'dost');
            $employee->signature = $filename;
            $employee->save();
        }

		return redirect()->route('Profile')->with('message', $message)->with('alert', $alert);
	}

	public function enroll_qrcode(Request $request, $uid) {
		$id = intval($uid);

		if ($id == 0) {
			$alert 		= 'alert-danger';
			$message = "Employee not found.";
			return redirect()->route('Profile')->with('message', $message)->with('alert', $alert);
		}

		$e = Employee::where('id', $id)->first();
		if (!$e) {
			$alert 		= 'alert-danger';
			$message = "Employee not found.";
			return redirect()->route('Profile')->with('message', $message)->with('alert', $alert);
		}

		$qr = new \hrmis\Models\QrCode;
		$qr->qrcode = $e->full_name.' DOST4A';
		$qr->e_id =$e->id;
		$qr->save();

		$alert 		= 'alert-success';
		$message = "QR Code updated.";
		return redirect()->route('Profile')->with('message', $message)->with('alert', $alert);
	}
}
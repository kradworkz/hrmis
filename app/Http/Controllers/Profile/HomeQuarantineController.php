<?php

namespace hrmis\Http\Controllers\Profile;

use Auth;
use hrmis\Models\Attachment;
use hrmis\Models\ApprovalStatus;
use hrmis\Models\EmployeeQuarantine;
use hrmis\Http\Controllers\Profile\Controller;
use Illuminate\Http\Request;

class HomeQuarantineController extends Controller
{
	public function index(Request $request)
	{
		$route 			= 'Home Quarantine';
		$quarantine 	= EmployeeQuarantine::where('employee_id', '=', Auth::id())->where('approval', '=', 1)->orderBy('created_at', 'desc')->get();
		return view('profile.quarantine.quarantine', compact('route', 'quarantine'));
	}

	public function view($id)
	{
		$quarantine 	= EmployeeQuarantine::find($id);
		$approvals 		= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 7)->get();
		return view('profile.quarantine.form', compact('id', 'quarantine', 'approvals'));
	}

	public function submit(Request $request, $id)
	{
		$alert 			= 'alert-info';
		$message 		= 'Medical Certificate successfully submitted.';
		$quarantine 	= EmployeeQuarantine::find($id);

		if($request->hasFile('attachments')) {

			$file 				= $request->file('attachments');
			$filename 			= $file->hashName();
			$path 				= $file->storeAs('attachments', $filename, 'dost');
			$attachment 		= Attachment::create([
				'module_id' 	=> $quarantine->id,
				'module_type' 	=> 7,
				'filename' 		=> $filename,
				'title' 		=> $file->getClientOriginalName(),
				'file_path' 	=> $path,
			]);

			$quarantine->status = 0;
			$quarantine->update();
		}

		return redirect()->route('Home Quarantine')->with('message', $message)->with('alert', $alert);
	}
}
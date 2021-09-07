<?php

namespace hrmis\Http\Controllers\Birthdays;

use Auth;
use hrmis\Models\PushNotification;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BirthdayController extends Controller
{
	public function index()
	{
		$bdays 		= PushNotification::whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") = "'.date('m-d').'"')->groupBy('employee_id')->get();
		$comments 	= PushNotification::whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") = "'.date('m-d').'"')->where('remarks', '!=', "")->get();
		$bday_month = PushNotification::whereMonth('date_of_birth', '=', date('m'))->groupBy('employee_id')->get();
		return view('birthdays.birthdays', compact('bdays', 'comments', 'bday_month'));
	}
}
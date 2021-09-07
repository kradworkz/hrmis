<?php

namespace hrmis\Http\Controllers;

use Auth;
use hrmis\Models\Notification;
use hrmis\Models\PushNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
	public function index()
	{
		return view('notifications.all');
	}

	public function read_birthday($id)
	{
		$birthday = PushNotification::find($id);
		$birthday->is_read = 1;
		$birthday->update();
	}

	public function read_all()
	{
		Notification::where('recipient_id', '=', Auth::id())->where('unread', '=', 0)->update(['unread' => 1]);
		return redirect()->back();
	}

	public function birthday_comment(Request $request)
	{
		$read_birthday 		= PushNotification::where('recipient_id', '=', Auth::id())->where('is_read', '=', 0)->update(['is_read' => 1]);
		$birthday 			= PushNotification::where('recipient_id', '=', Auth::id())->whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") = "'.date('m-d').'"')->first();
		$birthday->remarks 	= $request->get('comment');
		$birthday->update();

		return redirect()->back();
	}
}
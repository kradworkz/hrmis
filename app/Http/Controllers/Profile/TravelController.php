<?php

namespace hrmis\Http\Controllers\Profile;

use Auth, Storage, URL, PDF;
use hrmis\Models\Travel;
use hrmis\Models\Employee;
use hrmis\Models\Notification;
use hrmis\Models\SignatoryGroup;
use hrmis\Models\TravelExpense;
use hrmis\Models\TravelDocument;
use hrmis\Models\ApprovalStatus;
use hrmis\Models\TravelPassenger;
use hrmis\Models\TravelFundExpense;
use hrmis\Http\Traits\CommentHelper;
use hrmis\Http\Traits\NotificationHelper;
use hrmis\Http\Controllers\Profile\Controller;
use hrmis\Http\Requests\TravelValidation;
use Illuminate\Http\Request;

class TravelController extends Controller
{
	use CommentHelper, NotificationHelper;

	public function index(Request $request)
	{
		$id 		= 0;
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$month 		= $request->get('month') == null ? date('m') : $request->get('month');
		$search 	= $request->get('search') == null ? '' : $request->get('search');

		$years 		= config('app.years');
		$months 	= config('app.months');
		$route 		= 'Travel Order';
		
		$travels 	= Travel::tagged(Auth::id())->search($search)->year($year)->month($month)->orderBy('start_date', 'desc')->paginate(50);
		return view('profile.travels.travels', compact('id', 'travels', 'year', 'years', 'route', 'months', 'month', 'search'));
	}

	public function new()
	{
		$id 		= 0;
		$travel 	= new Travel;
		$employees 	= Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		$expenses  	= TravelExpense::where('id', '!=', 3)->get();
		return view('profile.travels.form', compact('id', 'travel', 'employees', 'expenses'));
	}

	public function edit($id)
	{
		$travel 	= Travel::find($id);
		$tfexpenses = TravelFundExpense::select(\DB::raw("*, CONCAT(expense_id,',',fund_id) as tfexpenses"))->where('travel_id', '=', $id)->pluck('tfexpenses')->toArray();
		$employees 	= Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		$expenses  	= TravelExpense::where('id', '!=', 3)->get();
		return view('profile.travels.form', compact('id', 'travel', 'employees', 'expenses', 'tfexpenses'));
	}

	public function tag($id, $employee_id = null)
	{
		$travel    = TravelPassenger::where('travel_id', '=', $id)->where('employee_id', '=', $employee_id == null ? Auth::id() : $employee_id)->delete();
		return redirect(URL::previous())->with('message', 'Travel Tag successfully removed.')->with('alert', 'alert-success');
	}

	public function delete($id)
	{
		$travel    = Travel::find($id);
		$travel->delete();
		return redirect(URL::previous())->with('message', 'Travel successfully deleted.')->with('alert', 'alert-success');
	}

	public function view($id)
	{
		$travel 	= Travel::find($id);
		$tfexpenses = TravelFundExpense::select(\DB::raw("*, CONCAT(expense_id,',',fund_id) as tfexpenses"))->where('travel_id', '=', $id)->pluck('tfexpenses')->toArray();
		$employees 	= Employee::where('is_active', '=', 1)->orderBy('last_name', 'asc')->get();
		$expenses  	= TravelExpense::where('id', '!=', 3)->get();
		Notification::where('reference_id', '=', $id)->where('type', '=', 'Travel Order')->where('recipient_id', '=', Auth::id())->update(['unread' => 1]);
		return view('profile.travels.view', compact('id', 'travel', 'employees', 'expenses', 'tfexpenses'));
	}

	public function status($id)
	{
		$approvals 		= ApprovalStatus::where('module', '=', $id)->where('module_id', '=', 2)->get();
		return view('layouts.status', compact('id', 'approvals'));
	}

	public function submit(TravelValidation $request, $id)
	{
		if(Auth::user()->unit->notification_signatory) {
			$request->request->add(['checked' 		=> 1]);
			$request->request->add(['checked_by' 	=> Auth::id()]);
		}

		if(Auth::user()->unit->offset_recommending == 0) {
			$request->request->add(['recommending' => 1]);
			$request->request->add(['recommending_by' => Auth::id()]);
		}

		$request->request->add(['employee_id' => Auth::id()]);
		$travel_fund_expenses 	= [];
		$passengers 			= $request->get('travel_passengers');
		if($request->get('expense_id')) {
			foreach($request->get('expense_id') as $expenses) {
				$travel_fund_expenses[] = ['fund_id' => explode(',', $expenses)[1], 'expense_id' => explode(',', $expenses)[0]];
			}
		}
		
		if($id == 0) {
			$alert 		= 'alert-success';
			$message 	= 'New travel order successfully added.';
			$travel 	= Travel::create($request->all());
			$notif_tags = $passengers;
			$travel->travel_passengers()->attach($request->get('travel_passengers'));
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
		}
		else {
			$alert 		= 'alert-info';
			$message 	= 'Travel Order successfully updated.';
			$travel 	= Travel::find($id);
			$notif_tags = array_diff($passengers, $travel->travel_passengers->pluck('id')->toArray());
			$travel->update($request->all());
			$travel->travel_passengers()->sync($request->get('travel_passengers'));
            $travel->travel_funds_expenses()->sync([]);
            $travel->travel_funds_expenses()->sync($travel_fund_expenses);
            if($request->hasFile('document_path')) {
                if($travel->has('travel_documents')) {
                    foreach($travel->travel_documents as $document) {
                        Storage::disk('dost')->delete($document->document_path);
                    }
                }
                $travel->travel_documents()->delete();
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
 		}

 		$this->submitComment($id == 0 ? $travel->id : $id, 2);
 		$this->newNotification($notif_tags, $travel->id, 'Travel Order', 'View Travel Order', 'Tag');
		return redirect()->route('Travel Order')->with('message', $message)->with('alert', $alert);
	}
}
<?php

namespace hrmis\Http\Controllers\Profile;

use Auth, URL, PDF;
use hrmis\Models\Role;
use hrmis\Models\Group;
use hrmis\Models\Employee;
use hrmis\Models\JobContract;
use hrmis\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobContractController extends Controller
{
	public function index(Request $request)
	{
		$year 		= $request->get('year') == null ? date('Y') : $request->get('year');
		$years 		= config('app.years');
		$contracts 	= JobContract::where('employee_id', '=', Auth::id())->get();
		return view('profile.contract.contract', compact('contracts', 'year', 'years'));
	}

	public function new()
	{
		$id 		= 0;
		$contract 	= new JobContract;
		return view('profile.contract.form', compact('id', 'contract'));
	}

	public function edit($id)
	{
		$contract 	= JobContract::find($id);
		return view('profile.contract.form', compact('id', 'contract'));
	}

	public function delete($id)
	{
		$contract 	= JobContract::find($id);
		$contract->delete();
		return redirect()->route('Job Contract')->with('message', 'Job Contract successfully deleted.')->with('alert', 'alert-success');
	}

	public function submit(Request $request, $id)
	{
		$request->request->add(['employee_id' => Auth::id()]);

		if($id == 0) {
			$alert 		= 'alert-success';
			$message 	= 'New job contract successfully added.';
			$contract 	= JobContract::create($request->all());
		}
		else {
			$alert 		= 'alert-info';
			$message 	= 'Job Contract successfully updated.';
			$contract 	= JobContract::find($id);
			$contract->update($request->all());
		}

		if($contract) {
			$this->createContractFile($contract);
		}

		return redirect()->route('Job Contract')->with('message', $message)->with('alert', $alert);
	}

	public function createContractFile($contract)
	{
		$dars = explode(PHP_EOL, $contract->duties_and_responsibilities);
		$dars_count = count($dars);
		$template_file = base_path('storage/dost/template/dost_contract_template_'.$dars_count.'.docx');

		$save_path = base_path('storage/dost/contract/'.$contract->created_at->format('Ymd').'-'.sprintf('%02d',$contract->employee_id)."-".sprintf('%02d',$contract->id).".docx");
		$template = new \PhpOffice\PhpWord\TemplateProcessor($template_file);

		$template->setValue('agency_head_name', strtoupper($contract->agency_head_name));
		$template->setValue('agency_head_designation', $contract->agency_head_designation);
		$template->setValue('name', strtoupper($contract->employee->full_name));
		$template->setValue('nationality', optional($contract->employee->info)->citizenship);
		$template->setValue('address', optional($contract->employee->info)->address);
		$template->setValue('employment_title', $contract->employment_title);
		$template->setValue('charging', $contract->charging);
		$template->setValue('salary_rate', $contract->salary_rate);
		$template->setValue('contract_duration', $contract->contract_duration);
		foreach($dars as $key => $dar) {
			$template->setValue('dar'.$key, str_replace('&','and',$dar));
		}
		$template->setValue('first_party_name', strtoupper($contract->first_party_name));
		$template->setValue('second_party_name', strtoupper($contract->second_party_name));
		$template->setValue('first_witness_name', strtoupper($contract->first_witness_name));
		$template->setValue('first_witness_designation', $contract->first_witness_designation);
		$template->setValue('second_witness_name', strtoupper($contract->second_witness_name));
		$template->setValue('second_witness_designation', $contract->second_witness_designation);
		$template->setValue('current_budget_officer_name', strtoupper($contract->current_budget_officer_name));
		$template->setValue('current_budget_officer_designation', $contract->current_budget_officer_designation);
		$template->setValue('current_accountant_name', strtoupper($contract->current_accountant_name));
		$template->setValue('current_accountant_designation', $contract->current_accountant_designation);
		$template->setValue('agency_head_id_name', strtoupper($contract->agency_head_id_name));
		$template->setValue('agency_head_id_number', $contract->agency_head_id_number);
		$template->setValue('agency_head_id_date_issued', $contract->agency_head_id_date_issued);
		$template->setValue('second_party_id_name', strtoupper($contract->second_party_id_name));
		$template->setValue('second_party_id_number', $contract->second_party_id_number);
		$template->setValue('second_party_id_date_issued', $contract->second_party_id_date_issued);
		$template->saveAs($save_path);
		chmod($save_path, 0644);
	}
}
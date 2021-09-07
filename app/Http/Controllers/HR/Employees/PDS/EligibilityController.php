<?php

namespace hrmis\Http\Controllers\HR\Employees\PDS;

use Storage;
use Carbon\Carbon;
use hrmis\Models\Employee;
use Illuminate\Http\Request;
use hrmis\Models\Eligibility;
use hrmis\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class EligibilityController extends Controller 
{
	public function index($id)
	{
		$route 					= 'Eligibility';
		$employee 				= Employee::find($id);
		$eligibility 			= Eligibility::where('employee_id', '=', $employee->id)->get();
		return view('hr.employees.pds.eligibility.table', compact('id', 'employee', 'eligibility', 'route'));
	}

	public function new($id, $employee_id)
	{
		$eligibility 			= new Eligibility;
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.eligibility.form', compact('id', 'employee', 'eligibility'));
	}

	public function edit($id, $employee_id)
	{
		$eligibility 			= Eligibility::find($id);
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.eligibility.form', compact('id', 'employee', 'eligibility'));
	}

	public function delete($id)
	{
		$alert 					= 'alert-warning';
		$message				= 'Civil Service Eligibility successfully deleted.';
		$eligibility 			= Eligibility::find($id);
		$eligibility->delete();

		$this->clear_sheet($eligibility->employee->username);
		$this->import_to_excel($eligibility);
		
		return redirect()->back()->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		if($id == 0) {
			$alert 					= 'alert-success';
			$message				= 'New civil service eligibility successfully added.';
			$eligibility 			= Eligibility::create($request->all());
		}
		else {
			$alert 					= 'alert-info';
			$message				= 'Civil Service Eligibility successfully updated.';
			$eligibility 			= Eligibility::find($id);
			$eligibility->update($request->all());
		}

		$this->import_to_excel($eligibility);

		return redirect()->route('Civil Service Eligibility', ['id' => $request->get('employee_id')])->with('message', $message)->with('alert', $alert);
	}

	function import_to_excel($eligibility)
	{
		$template 		= $this->get_pds_file($eligibility->employee->username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$this->second_sheet($spreadsheet->getSheet(1), $eligibility->employee_id);

		$writer 		= new Writer($spreadsheet);
		$filename 		= $eligibility->employee->username;
		$url 			= base_path().'/storage/dost/pds/'.$filename.'.xlsx';
		$writer->save($url);
	}

	function get_pds_file($username)
	{
		$pds = base_path().'/storage/dost/pds/'.$username.'.xlsx';
		
		if(file_exists($pds)) {
			$template 	= $pds;
		}
		else {
			$template 	= 'hrmis_template.xlsx';
		}

		return $template;
	}

	function second_sheet($sheet, $id)
	{
		$cell 		 = 5;
		$eligibility = Eligibility::where('employee_id', '=', $id)->get();

		if($eligibility) {
			foreach($eligibility as $csc) {
				$sheet->setCellValue('A'.$cell, $csc->eligibility_name);
				$sheet->setCellValue('F'.$cell, $csc->rating);
				$sheet->setCellValue('G'.$cell, optional($csc->date_of_examination)->format('m/d/Y'));
				$sheet->setCellValue('I'.$cell, $csc->place_of_examination);
				$sheet->setCellValue('L'.$cell, $csc->eligibility_number);
				$sheet->setCellValue('M'.$cell, $csc->date_of_validity);
				$cell++;
				if($cell >= 11) { break; }
			}
		}
	}

	function clear_sheet($username)
	{
		$template 		= $this->get_pds_file($username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$sheet 			= $spreadsheet->getSheet(1);

		for ($i=5; $i <= 11; $i++) {
			$sheet->setCellValue('A'.$i, "");
			$sheet->setCellValue('F'.$i, "");
			$sheet->setCellValue('G'.$i, "");
			$sheet->setCellValue('I'.$i, "");
			$sheet->setCellValue('L'.$i, "");
			$sheet->setCellValue('M'.$i, "");
		}

		$writer 		= new Writer($spreadsheet);
		$url 			= base_path().'/storage/dost/pds/'.$username.'.xlsx';
		$writer->save($url);
	}
}
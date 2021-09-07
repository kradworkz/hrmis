<?php

namespace hrmis\Http\Controllers\HR\Employees\PDS;

use Storage;
use Carbon\Carbon;
use hrmis\Models\Employee;
use Illuminate\Http\Request;
use hrmis\Models\OtherInformation;
use hrmis\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class OtherInformationController extends Controller 
{
	public function index($id)
	{
		$route 					= 'OtherInformation';
		$employee 				= Employee::find($id);
		$other_info 			= OtherInformation::where('employee_id', '=', $employee->id)->get();
		return view('hr.employees.pds.other_information.table', compact('id', 'employee', 'other_info', 'route'));
	}

	public function new($id, $employee_id)
	{
		$other_info 			= new OtherInformation;
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.other_information.form', compact('id', 'employee', 'other_info'));
	}

	public function edit($id, $employee_id)
	{
		$other_info 			= OtherInformation::find($id);
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.other_information.form', compact('id', 'employee', 'other_info'));
	}

	public function delete($id)
	{
		$alert 					= 'alert-warning';
		$message				= 'Information successfully deleted.';
		$other_info 			= OtherInformation::find($id);
		$other_info->delete();

		$this->clear_sheet($other_info->employee->username);
		$this->import_to_excel($other_info);
		
		return redirect()->back()->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		if($id == 0) {
			$alert 					= 'alert-success';
			$message				= 'New Information successfully added.';
			$other_info 				= OtherInformation::create($request->all());
		}
		else {
			$alert 					= 'alert-info';
			$message				= 'Information successfully updated.';
			$other_info 			= OtherInformation::find($id);
			$other_info->update($request->all());
		}

		$this->import_to_excel($other_info);

		return redirect()->route('Other Information', ['id' => $request->get('employee_id')])->with('message', $message)->with('alert', $alert);
	}

	function import_to_excel($other_info)
	{
		$template 		= $this->get_pds_file($other_info->employee->username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$this->third_sheet($spreadsheet->getSheet(2), $other_info->employee_id);

		$writer 		= new Writer($spreadsheet);
		$filename 		= $other_info->employee->username;
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

	function third_sheet($sheet, $id)
	{
		$cell 		 = 43;
		$other_info  = OtherInformation::where('employee_id', '=', $id)->get();

		if($other_info) {
			foreach($other_info as $info) {
				$sheet->setCellValue('A'.$cell, $info->skills);
				$sheet->setCellValue('C'.$cell, $info->recognition);
				$sheet->setCellValue('I'.$cell, $info->organization);
				$cell++;
				if($cell >= 49) { break; }
			}
		}
	}

	function clear_sheet($username)
	{
		$template 		= $this->get_pds_file($username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$sheet 			= $spreadsheet->getSheet(2);

		for ($i=43; $i <= 49; $i++) {
			$sheet->setCellValue('A'.$i, "");
			$sheet->setCellValue('C'.$i, "");
			$sheet->setCellValue('I'.$i, "");
		}

		$writer 		= new Writer($spreadsheet);
		$url 			= base_path().'/storage/dost/pds/'.$username.'.xlsx';
		$writer->save($url);
	}
}
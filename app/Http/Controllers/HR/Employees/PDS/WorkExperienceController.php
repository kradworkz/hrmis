<?php

namespace hrmis\Http\Controllers\HR\Employees\PDS;

use Storage;
use Carbon\Carbon;
use hrmis\Models\Employee;
use Illuminate\Http\Request;
use hrmis\Models\WorkExperience;
use hrmis\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class WorkExperienceController extends Controller 
{
	public function index($id)
	{
		$route 					= 'Work Experience';
		$employee 				= Employee::find($id);
		$work_exp 				= WorkExperience::where('employee_id', '=', $employee->id)->get();
		return view('hr.employees.pds.work_experience.table', compact('id', 'employee', 'work_exp', 'route'));
	}

	public function new($id, $employee_id)
	{
		$work_exp 				= new WorkExperience;
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.work_experience.form', compact('id', 'employee', 'work_exp'));
	}

	public function edit($id, $employee_id)
	{
		$work_exp 				= WorkExperience::find($id);
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.work_experience.form', compact('id', 'employee', 'work_exp'));
	}

	public function delete($id)
	{
		$alert 					= 'alert-warning';
		$message				= 'Work Experience successfully deleted.';
		$work_exp 			= WorkExperience::find($id);
		$work_exp->delete();

		$this->clear_sheet($work_exp->employee->username);
		$this->import_to_excel($work_exp);
		
		return redirect()->back()->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		if($id == 0) {
			$alert 					= 'alert-success';
			$message				= 'New work experience successfully added.';
			$work_exp 				= WorkExperience::create($request->all());
		}
		else {
			$alert 					= 'alert-info';
			$message				= 'Work Experience successfully updated.';
			$work_exp 				= WorkExperience::find($id);
			$work_exp->update($request->all());
		}

		$this->import_to_excel($work_exp);

		return redirect()->route('Work Experience', ['id' => $request->get('employee_id')])->with('message', $message)->with('alert', $alert);
	}

	function import_to_excel($work_exp)
	{
		$template 		= $this->get_pds_file($work_exp->employee->username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$this->second_sheet($spreadsheet->getSheet(1), $work_exp->employee_id);

		$writer 		= new Writer($spreadsheet);
		$filename 		= $work_exp->employee->username;
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
		$cell 		 = 18;
		$work_exp 	 = WorkExperience::where('employee_id', '=', $id)->get();

		if($work_exp) {
			foreach($work_exp as $exp) {
				$sheet->setCellValue('A'.$cell, optional($exp->start_date)->format('m-d-Y'));
				$sheet->setCellValue('C'.$cell, optional($exp->end_date)->format('m-d-Y'));
				$sheet->setCellValue('D'.$cell, $exp->position_title);
				$sheet->setCellValue('G'.$cell, $exp->company);
				$sheet->setCellValue('J'.$cell, $exp->monthly_salary);
				$sheet->setCellValue('K'.$cell, $exp->salary_grade);
				$sheet->setCellValue('L'.$cell, $exp->status_of_appointment);
				$sheet->setCellValue('M'.$cell, $exp->is_government == 1 ? 'Yes' : 'No');
				$cell++;
				if($cell >= 45) { break; }
			}
		}
	}

	function clear_sheet($username)
	{
		$template 		= $this->get_pds_file($username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$sheet 			= $spreadsheet->getSheet(1);

		for ($i=18; $i <= 45; $i++) {
			$sheet->setCellValue('A'.$i, "");
			$sheet->setCellValue('C'.$i, "");
			$sheet->setCellValue('D'.$i, "");
			$sheet->setCellValue('G'.$i, "");
			$sheet->setCellValue('J'.$i, "");
			$sheet->setCellValue('K'.$i, "");
			$sheet->setCellValue('L'.$i, "");
			$sheet->setCellValue('M'.$i, "");
		}

		$writer 		= new Writer($spreadsheet);
		$url 			= base_path().'/storage/dost/pds/'.$username.'.xlsx';
		$writer->save($url);
	}
}
<?php

namespace hrmis\Http\Controllers\HR\Employees\PDS;

use Storage;
use Carbon\Carbon;
use hrmis\Models\Employee;
use Illuminate\Http\Request;
use hrmis\Models\Training;
use hrmis\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class TrainingController extends Controller 
{
	public function index($id)
	{
		$route 					= 'Training';
		$employee 				= Employee::find($id);
		$training 				= Training::where('employee_id', '=', $employee->id)->get();
		return view('hr.employees.pds.training.table', compact('id', 'employee', 'training', 'route'));
	}

	public function new($id, $employee_id)
	{
		$training 				= new Training;
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.training.form', compact('id', 'employee', 'training'));
	}

	public function edit($id, $employee_id)
	{
		$training 				= Training::find($id);
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.training.form', compact('id', 'employee', 'training'));
	}

	public function delete($id)
	{
		$alert 					= 'alert-warning';
		$message				= 'Training successfully deleted.';
		$training 			= Training::find($id);
		$training->delete();

		$this->clear_sheet($training->employee->username);
		$this->import_to_excel($training);
		
		return redirect()->back()->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		if($id == 0) {
			$alert 					= 'alert-success';
			$message				= 'New Training successfully added.';
			$training 				= Training::create($request->all());
		}
		else {
			$alert 					= 'alert-info';
			$message				= 'Training successfully updated.';
			$training 				= Training::find($id);
			$training->update($request->all());
		}

		$this->import_to_excel($training);

		return redirect()->route('Training', ['id' => $request->get('employee_id')])->with('message', $message)->with('alert', $alert);
	}

	function import_to_excel($training)
	{
		$template 		= $this->get_pds_file($training->employee->username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$this->third_sheet($spreadsheet->getSheet(2), $training->employee_id);

		$writer 		= new Writer($spreadsheet);
		$filename 		= $training->employee->username;
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
		$cell 		 = 19;
		$training 	 = Training::where('employee_id', '=', $id)->get();

		if($training) {
			foreach($training as $t) {
				$sheet->setCellValue('A'.$cell, $t->title);
				$sheet->setCellValue('E'.$cell, optional($t->start_date)->format('m-d-Y'));
				$sheet->setCellValue('F'.$cell, optional($t->end_date)->format('m-d-Y'));
				$sheet->setCellValue('G'.$cell, $t->number_of_hours);
				$sheet->setCellValue('H'.$cell, $t->type);
				$sheet->setCellValue('I'.$cell, $t->conducted_by);
				$cell++;
				if($cell >= 39) { break; }
			}
		}
	}

	function clear_sheet($username)
	{
		$template 		= $this->get_pds_file($username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$sheet 			= $spreadsheet->getSheet(2);

		for ($i=19; $i <= 39; $i++) {
			$sheet->setCellValue('A'.$i, "");
			$sheet->setCellValue('E'.$i, "");
			$sheet->setCellValue('F'.$i, "");
			$sheet->setCellValue('G'.$i, "");
			$sheet->setCellValue('H'.$i, "");
			$sheet->setCellValue('I'.$i, "");
		}

		$writer 		= new Writer($spreadsheet);
		$url 			= base_path().'/storage/dost/pds/'.$username.'.xlsx';
		$writer->save($url);
	}
}
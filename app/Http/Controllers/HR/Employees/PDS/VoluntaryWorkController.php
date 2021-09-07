<?php

namespace hrmis\Http\Controllers\HR\Employees\PDS;

use Storage;
use Carbon\Carbon;
use hrmis\Models\Employee;
use Illuminate\Http\Request;
use hrmis\Models\VoluntaryWork;
use hrmis\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class VoluntaryWorkController extends Controller 
{
	public function index($id)
	{
		$route 					= 'Voluntary Work';
		$employee 				= Employee::find($id);
		$vol_work 				= VoluntaryWork::where('employee_id', '=', $employee->id)->get();
		return view('hr.employees.pds.voluntary_work.table', compact('id', 'employee', 'vol_work', 'route'));
	}

	public function new($id, $employee_id)
	{
		$vol_work 				= new VoluntaryWork;
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.voluntary_work.form', compact('id', 'employee', 'vol_work'));
	}

	public function edit($id, $employee_id)
	{
		$vol_work 				= VoluntaryWork::find($id);
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.voluntary_work.form', compact('id', 'employee', 'vol_work'));
	}

	public function delete($id)
	{
		$alert 					= 'alert-warning';
		$message				= 'Voluntary Work successfully deleted.';
		$vol_work 			= VoluntaryWork::find($id);
		$vol_work->delete();

		$this->clear_sheet($vol_work->employee->username);
		$this->import_to_excel($vol_work);
		
		return redirect()->back()->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		if($id == 0) {
			$alert 					= 'alert-success';
			$message				= 'New Voluntary Work successfully added.';
			$vol_work 				= VoluntaryWork::create($request->all());
		}
		else {
			$alert 					= 'alert-info';
			$message				= 'Voluntary Work successfully updated.';
			$vol_work 				= VoluntaryWork::find($id);
			$vol_work->update($request->all());
		}

		$this->import_to_excel($vol_work);

		return redirect()->route('Voluntary Work', ['id' => $request->get('employee_id')])->with('message', $message)->with('alert', $alert);
	}

	function import_to_excel($vol_work)
	{
		$template 		= $this->get_pds_file($vol_work->employee->username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$this->third_sheet($spreadsheet->getSheet(2), $vol_work->employee_id);

		$writer 		= new Writer($spreadsheet);
		$filename 		= $vol_work->employee->username;
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
		$cell 		 = 6;
		$vol_work 	 = VoluntaryWork::where('employee_id', '=', $id)->get();

		if($vol_work) {
			foreach($vol_work as $exp) {
				$sheet->setCellValue('A'.$cell, $exp->org_info);
				$sheet->setCellValue('E'.$cell, optional($exp->start_date)->format('m-d-Y'));
				$sheet->setCellValue('F'.$cell, optional($exp->end_date)->format('m-d-Y'));
				$sheet->setCellValue('G'.$cell, $exp->number_of_hours);
				$sheet->setCellValue('H'.$cell, $exp->position);
				$cell++;
				if($cell >= 12) { break; }
			}
		}
	}

	function clear_sheet($username)
	{
		$template 		= $this->get_pds_file($username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$sheet 			= $spreadsheet->getSheet(2);

		for ($i=6; $i <= 12; $i++) {
			$sheet->setCellValue('A'.$i, "");
			$sheet->setCellValue('E'.$i, "");
			$sheet->setCellValue('F'.$i, "");
			$sheet->setCellValue('G'.$i, "");
			$sheet->setCellValue('H'.$i, "");
		}

		$writer 		= new Writer($spreadsheet);
		$url 			= base_path().'/storage/dost/pds/'.$username.'.xlsx';
		$writer->save($url);
	}
}
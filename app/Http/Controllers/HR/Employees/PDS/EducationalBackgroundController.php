<?php

namespace hrmis\Http\Controllers\HR\Employees\PDS;

use Storage;
use Carbon\Carbon;
use hrmis\Models\Employee;
use Illuminate\Http\Request;
use hrmis\Models\EducationalBackground;
use hrmis\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class EducationalBackgroundController extends Controller 
{
	public function index($id)
	{
		$route 					= 'Educational Background';
		$employee 				= Employee::find($id);
		$educational_background = EducationalBackground::where('employee_id', '=', $employee->id)->get();
		return view('hr.employees.pds.educational_background.table', compact('id', 'employee', 'educational_background', 'route'));
	}

	public function new($id, $employee_id)
	{
		$educational_background = new EducationalBackground;
		$employee 				= Employee::find($employee_id);
		$levels 				= array('Elementary', 'Secondary', 'Vocational/Trade Course', 'College', 'Graduate Studies');
		return view('hr.employees.pds.educational_background.form', compact('id', 'employee', 'educational_background', 'levels'));
	}

	public function edit($id, $employee_id)
	{
		$educational_background = EducationalBackground::find($id);
		$employee 				= Employee::find($employee_id);
		$levels 				= array('Elementary', 'Secondary', 'Vocational/Trade Course', 'College', 'Graduate Studies');
		return view('hr.employees.pds.educational_background.form', compact('id', 'employee', 'educational_background', 'levels'));
	}

	public function delete($id)
	{
		$alert 					= 'alert-warning';
		$message				= 'Educational Background successfully deleted.';
		$educational_background = EducationalBackground::find($id);
		$this->clear_cells($educational_background->type, $educational_background->employee->username);
		$educational_background->delete();

		return redirect()->back()->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		if($id == 0) {
			$alert 					= 'alert-success';
			$message				= 'New educational background successfully added.';
			$educational_background = EducationalBackground::create($request->all());
		}
		else {
			$alert 					= 'alert-info';
			$message				= 'Educational Background successfully updated.';
			$educational_background = EducationalBackground::find($id);
			$this->clear_cells($educational_background->type, $educational_background->employee->username);
			$educational_background->update($request->all());
		}

		$this->import_to_excel($educational_background);

		return redirect()->route('Educational Background', ['id' => $request->get('employee_id')])->with('message', $message)->with('alert', $alert);
	}

	function import_to_excel($educational_background)
	{
		$template 		= $this->get_pds_file($educational_background->employee->username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$this->first_sheet($spreadsheet->getSheet(0), $educational_background);

		$writer 		= new Writer($spreadsheet);
		$filename 		= $educational_background->employee->username;
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

	function first_sheet($sheet, $educational_background)
	{
		$cell_value = $this->get_cell_value($educational_background->type);
		$sheet->setCellValue('D'.$cell_value, $educational_background->name_of_school);
		$sheet->setCellValue('G'.$cell_value, $educational_background->degree);
		$sheet->setCellValue('J'.$cell_value, optional($educational_background->period_from)->format('Y-m-d'));
		$sheet->setCellValue('K'.$cell_value, optional($educational_background->period_to)->format('Y-m-d'));
		$sheet->setCellValue('L'.$cell_value, $educational_background->units_earned);
		$sheet->setCellValue('M'.$cell_value, $educational_background->year_graduated);
		$sheet->setCellValue('N'.$cell_value, $educational_background->scholarship);
	}

	function get_cell_value($type)
	{
		if($type == 0) {
			$cell_value = 54;
		}
		elseif($type == 1) {
			$cell_value = 55;
		}
		elseif($type == 2) {
			$cell_value = 56;
		}
		elseif($type == 3) {
			$cell_value = 57;
		}
		elseif($type == 4) {
			$cell_value = 58;
		}

		return $cell_value;
	}

	function clear_cells($cell_value, $username)
	{
		$cell_value 	= $this->get_cell_value($cell_value);
		$template 		= $this->get_pds_file($username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$sheet 			= $spreadsheet->getSheet(0);

		$sheet->setCellValue('D'.$cell_value, "");
		$sheet->setCellValue('G'.$cell_value, "");
		$sheet->setCellValue('J'.$cell_value, "");
		$sheet->setCellValue('K'.$cell_value, "");
		$sheet->setCellValue('L'.$cell_value, "");
		$sheet->setCellValue('M'.$cell_value, "");
		$sheet->setCellValue('N'.$cell_value, "");

		$writer 		= new Writer($spreadsheet);
		$url 			= base_path().'/storage/dost/pds/'.$username.'.xlsx';
		$writer->save($url);
	}
}
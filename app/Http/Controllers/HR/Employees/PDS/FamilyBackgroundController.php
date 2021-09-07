<?php

namespace hrmis\Http\Controllers\HR\Employees\PDS;

use Storage;
use Carbon\Carbon;
use hrmis\Models\Children;
use hrmis\Models\Employee;
use Illuminate\Http\Request;
use hrmis\Models\FamilyBackground;
use hrmis\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class FamilyBackgroundController extends Controller 
{
	public function index($id)
	{
		$route 					= 'Family Background';
		$employee 				= Employee::find($id);
		$family_background 		= FamilyBackground::where('employee_id', '=', $employee->id)->first();
		$children 				= Children::where('employee_id', '=', $id)->get();

		if($family_background == null) {
			$family_background = new FamilyBackground;
		}

		return view('hr.employees.pds.family_background.form', compact('id', 'employee', 'family_background', 'children', 'route'));
	}

	public function new($id, $employee_id)
	{
		$id 					= 0;
		$children 				= new Children;
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.family_background.child_form', compact('id', 'employee', 'children'));
	}

	public function edit($id, $employee_id)
	{
		$children 				= Children::find($id);
		$employee 				= Employee::find($employee_id);
		return view('hr.employees.pds.family_background.child_form', compact('id', 'employee', 'children'));
	}

	public function delete($id)
	{
		$alert 					= 'alert-warning';
		$message				= 'Child successfully deleted.';
		$children 				= Children::find($id);
		$children->delete();

		return redirect()->back()->with('message', $message)->with('alert', $alert);
	}

	public function child_submit(Request $request, $id)
	{
		$request->request->add(['date_of_birth' => Carbon::parse($request->get('date_of_birth'))->format('Y-m-d')]);

		if($id == 0) {
			$alert 			= 'alert-success';
			$message		= 'New child successfully added.';
			Children::create($request->all());
		}
		else {
			$alert 			= 'alert-info';
			$message		= 'Child information successfully updated.';
			$child 			= Children::find($id);
			$child->update($request->all());
		}

		return redirect()->route('Family Background', ['id' => $request->get('employee_id')])->with('message', $message)->with('alert', $alert);
	}

	public function submit(Request $request, $id)
	{
		$alert 				= 'alert-info';
		$message			= 'Family Background successfully updated.';
		$family_background 	= FamilyBackground::where('employee_id', '=', $id)->first();

		if($family_background == null) {
			$family_background = FamilyBackground::create($request->all());
		}
		else {
			$family_background->update($request->all());
		}

		$this->import_to_excel($family_background);

		return redirect()->route('Family Background', ['id' => $id])->with('message', $message)->with('alert', $alert);
	}

	function import_to_excel($family_background)
	{
		$template 		= $this->get_pds_file($family_background->employee->username);
		
		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$this->first_sheet($spreadsheet->getSheet(0), $family_background);

		$writer 		= new Writer($spreadsheet);
		$filename 		= $family_background->employee->username;
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

	function first_sheet($sheet, $family_background)
	{
		$sheet->setCellValue('D36', $family_background->spouse_last_name);
		$sheet->setCellValue('D37', $family_background->spouse_middle_name);
		$sheet->setCellValue('D38', $family_background->spouse_first_name);
		$sheet->setCellValue('G37', "NAME EXTENSION (JR., SR)\n". $family_background->spouse_name_extension);
		$sheet->setCellValue('D39', $family_background->spouse_occupation);
		$sheet->setCellValue('D40', $family_background->business_name);
        $sheet->setCellValue('D41', $family_background->business_address);
        $sheet->setCellValue('D42', $family_background->business_telephone);
        $sheet->setCellValue('D43', $family_background->father_last_name);
        $sheet->setCellValue('D44', $family_background->father_first_name);
        $sheet->setCellValue('D45', $family_background->father_middle_name);
        $sheet->setCellValue('G44', "NAME EXTENSION (JR., SR)\n". $family_background->father_name_extension);
        $sheet->setCellValue('D46', $family_background->mother_maiden_name);
        $sheet->setCellValue('D47', $family_background->mother_last_name);
        $sheet->setCellValue('D48', $family_background->mother_first_name);
        $sheet->setCellValue('D49', $family_background->mother_middle_name);

        $total = count($family_background->children);
        if($total) {
        	$cell = 37;
        	foreach($family_background->children as $child) {
        		$sheet->setCellValue('I'.$cell, $child->full_name);
        		$sheet->setCellValue('M'.$cell, optional($child->date_of_birth)->format('Y-m-d'));
        		$cell++;

        		if($cell > 49) { 
        			break; 
        		}
        	}
        }
	}
}
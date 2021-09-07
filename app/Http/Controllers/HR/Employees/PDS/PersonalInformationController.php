<?php

namespace hrmis\Http\Controllers\HR\Employees\PDS;

use Carbon\Carbon, Storage;
use hrmis\Models\Employee;
use Illuminate\Http\Request;
use hrmis\Models\PersonalInformation;
use hrmis\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class PersonalInformationController extends Controller 
{
	public function index(Request $request, $id)
	{
		$route 			= 'Personal Information';
		$employee 		= Employee::find($id);
		$personal_info 	= PersonalInformation::where('employee_id', '=', $employee->id)->first();

		if($personal_info == null) {
			$personal_info = new PersonalInformation;
		}

		return view('hr.employees.pds.personal_information.form', compact('id', 'employee', 'personal_info', 'route'));
	}

	public function submit(Request $request, $id)
	{
		$request->request->add(['date_of_birth' => Carbon::parse($request->get('birthday'))->format('Y-m-d')]);

		$alert 			= 'alert-info';
		$message		= 'Personal Information successfully updated.';
		$personal_info 	= PersonalInformation::where('employee_id', '=', $id)->first();

		if($personal_info == null) {
			$personal_info = PersonalInformation::create($request->all());
		}
		else {
			$personal_info->update($request->all());
		}

		$this->import_to_excel($personal_info);

		return redirect()->route('Personal Information', ['id' => $id])->with('message', $message)->with('alert', $alert);
	}

	function import_to_excel($personal_info)
	{
		$template 		= $this->get_pds_file($personal_info->employee->username);

		$reader 		= new Reader();
		$spreadsheet 	= $reader->load($template);
		$this->first_sheet($spreadsheet->getSheet(0), $personal_info);

		$writer 		= new Writer($spreadsheet);
		$filename 		= $personal_info->employee->username;
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

	function first_sheet($sheet, $personal_info)
	{
		$sheet->setCellValue('D10', $personal_info->last_name);
		$sheet->setCellValue('D11', $personal_info->first_name);
		$sheet->setCellValue('N11', $personal_info->name_extension);
		$sheet->setCellValue('D12', $personal_info->middle_name);
		$sheet->setCellValue('D13', $personal_info->date_of_birth);
		$sheet->setCellValue('D15', $personal_info->place_of_birth);
		$sheet->setCellValue('D16', $personal_info->gender); 
		$sheet->setCellValue('D15', $personal_info->place_of_birth);
		$sheet->setCellValue('D17', $personal_info->civil_status);
		$sheet->setCellValue('D22', $personal_info->height);
		$sheet->setCellValue('D24', $personal_info->weight);
		$sheet->setCellValue('D25', $personal_info->blood_type);
		$sheet->setCellValue('D29', $personal_info->pagibig_id);
		$sheet->setCellValue('D31', $personal_info->philhealth_id);
		$sheet->setCellValue('D32', $personal_info->sss_id);
		$sheet->setCellValue('D33', $personal_info->tin_id);
		$sheet->setCellValue('D34', $personal_info->agency_employee_number);
		$sheet->setCellValue('J13', $personal_info->citizenship);

		// Residential Address
		$sheet->setCellValue('I17', $personal_info->residential_house_info);
		$sheet->setCellValue('L17', $personal_info->residential_street);
		$sheet->setCellValue('I19', $personal_info->residential_subdivision);
		$sheet->setCellValue('L19', $personal_info->residential_barangay);
		$sheet->setCellValue('I22', $personal_info->residential_city);
		$sheet->setCellValue('L22', $personal_info->residential_province);
		$sheet->setCellValue('I24', $personal_info->residential_zip_code);

		// Permanent Address
		$sheet->setCellValue('I25', $personal_info->permanent_house_info);
		$sheet->setCellValue('L25', $personal_info->permanent_street);
		$sheet->setCellValue('I27', $personal_info->permanent_subdivision);
		$sheet->setCellValue('L27', $personal_info->permanent_barangay);
		$sheet->setCellValue('I29', $personal_info->permanent_city);
		$sheet->setCellValue('L29', $personal_info->permanent_province);
		$sheet->setCellValue('I31', $personal_info->permanent_zip_code);

		$sheet->setCellValue('I32', $personal_info->telephone_number);
		$sheet->setCellValue('I33', $personal_info->mobile_number);
		$sheet->setCellValue('I34', $personal_info->email);
	}
}
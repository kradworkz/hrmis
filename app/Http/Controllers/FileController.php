<?php

namespace hrmis\Http\Controllers;

use Auth, Image, Storage;
use hrmis\Models\Travel;
use hrmis\Models\Offset;
use hrmis\Models\Employee;
use hrmis\Models\Attachment;
use hrmis\Models\JobContract;
use hrmis\Models\TravelDocument;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class FileController extends Controller
{
	public function travel_documents($filename)
	{
		$documents = TravelDocument::where('filename', '=', $filename)->first();

        if($documents->travel_order->employee_id == Auth::id() || $documents->travel_order->travel_passengers->contains(Auth::id()) || Auth::user()->travel_signatory || Auth::user()->is_superuser()) {
            $document_path = base_path('storage/dost/travel_documents/'.$filename);
            if(Storage::disk('dost')->exists('travel_documents/'.$filename)) {
                return response()->download($document_path); 
            }
            else {
                return redirect()->back()->with('message', 'File not found!')->with('alert', 'alert-danger');
            }
        }

    	return redirect()->back()->with('message', 'You are not authorized to do this action.')->with('alert', 'alert-danger');
	}

    public function pds($username)
    {
        if(Auth::user()->username == $username || Auth::user()->is_hr()) {
            $filename = $username.'.xlsx';
            $document_path = base_path('storage/dost/pds/'.$filename);
            if(Storage::disk('dost')->exists('pds/'.$filename)) {
                return response()->download($document_path); 
            }
            else {
                return redirect()->back()->with('message', 'File not found!')->with('alert', 'alert-danger');
            }
        }

        return redirect()->back()->with('message', 'You are not authorized to do this action.')->with('alert', 'alert-danger');
    }

    public function contract($id)
    {
        $contract = JobContract::find($id);
        $filename = $contract->created_at->format('Ymd').'-'.sprintf('%02d',$contract->employee_id)."-".sprintf('%02d',$contract->id).".docx";
        $document_path = base_path('storage/dost/contract/'.$filename);
        if(Storage::disk('dost')->exists('contract/'.$filename)) {
            return response()->download($document_path); 
        }
        else {
            return redirect()->back()->with('message', 'File not found!')->with('alert', 'alert-danger');
        }

        return redirect()->back()->with('message', 'You are not authorized to do this action.')->with('alert', 'alert-danger');
    }

    public function attachments($filename)
    {
        $file           = Attachment::where('filename', '=', $filename)->first();
        $document_path  = base_path('storage/dost/attachments/'.$filename);
        if(Storage::disk('dost')->exists('attachments/'.$filename)) {
            return Image::make($document_path)->response();
        }
        else {
            return redirect()->back()->with('message', 'File not found!')->with('alert', 'alert-danger');
        }

        return redirect()->back()->with('message', 'You are not authorized to do this action.')->with('alert', 'alert-danger');
    }

    public function employee_signature($filename)
    {
        if(Auth::user()->signature == $filename || Auth::user()->is_superuser() || Auth::user()->is_administrator()) {
            return Image::make(base_path('storage/dost/employee_signature/'.$filename))->response();
        }
        return redirect()->back()->with('message', 'You are not authorized to do this action.')->with('alert', 'alert-danger');
    }

    public function download_signature($filename)
    {
        if($filename != "") {
            if(Storage::disk('dost')->exists('employee_signature/'.$filename)) {
                $path = storage_path('dost/employee_signature/'.$filename);
                if(Auth::user()->is_superuser() || Auth::user()->is_hr()) {
                    return response()->download($path);
                }
            }
            else {
                return redirect()->route('Employees')->with('message', 'File not found.')->with('alert', 'alert-danger');
            }
        }
    }
    
    public function profile_picture($filename)
    {
        if(file_exists(base_path('storage/app/public/profile/'.$filename))) {
            return Image::make(base_path('storage/app/public/profile/'.$filename))->response();
        }
        else {
            return Image::make(base_path('storage/app/public/profile/blank-profile.jpg'))->response();
        }
    }

    public function generate_attachments($id, $start_date, $end_date)
    {
        $employee   = Employee::find($id);
        $this->import_to_excel($employee, $start_date, $end_date);

        $year       = date('Y');
        $month      = date('m');

        $file       = public_path().'/attachments/'.$year.'/'.$month.'/'.$employee->username.'.xlsx';
        $headers    = array('Content-Type: application/excel');
        return \Response::download($file, $year."-".$month."-".$employee->username.".xlsx");
    }

    function import_to_excel($employee, $start_date, $end_date)
    {
        $template       = 'attachment_template.xlsx';

        $reader         = new Reader();
        $spreadsheet    = $reader->load($template);

        $travel_sheet   = $spreadsheet->getSheet(0);
        $this->travel_sheet($travel_sheet, $employee->id, $start_date, $end_date);
        $off_sheet      = $spreadsheet->getSheet(1);
        $this->offset_sheet($off_sheet, $employee->id, $start_date, $end_date);

        $year           = date('Y');
        $month          = date('m');

        $writer         = new Writer($spreadsheet);
        $path           = 'attachments/'.$year.'/'.$month.'/';
        $filename       = $employee->username;
        if(!file_exists($path)) {
            \File::makeDirectory(public_path().'/attachments/'.$year.'/'.$month, 0777, true);
        }
        $writer->save('attachments/'.$year.'/'.$month.'/'.$filename.'.xlsx');
    }

    function travel_sheet($sheet, $id, $start_date, $end_date)
    {
        $cell           = 4;
        $year           = date('Y');
        $month          = date('m');

        $employee       = Employee::find($id);
        $travels        = Travel::tagged($id)->between($start_date, $end_date)->orderBy('start_date', 'desc')->get();

        $sheet->setCellValue('A1', 'Travel Order Summary, '.$start_date." to ".$end_date);
        $sheet->setCellValue('A2', $employee->full_name);
        $sheet->setCellValue('C2', $employee->unit->name);

        foreach($travels as $travel) {
            $sheet->setCellValue('A'.$cell, $travel->travel_dates);
            $sheet->setCellValue('B'.$cell, $travel->destination);
            $sheet->setCellValue('C'.$cell, $travel->purpose);
            $sheet->setCellValue('D'.$cell, $travel->approval == 1 ? 'Approved' : ($travel->approval == 0 ? 'Pending' : 'Disapproved'));
            $sheet->setCellValue('E'.$cell, $travel->created_at->format('F d, Y'));
            $cell++;
        }
    }

    function offset_sheet($sheet, $id, $start_date, $end_date)
    {
        $cell           = 4;

        $employee       = Employee::find($id);
        $offset         = Offset::where('employee_id', '=', $employee->id)->whereBetween('date', [$start_date, $end_date])->orderBy('date', 'desc')->get();

        $sheet->setCellValue('A1', 'Offset Summary, '.$start_date." to ".$end_date);
        $sheet->setCellValue('A2', $employee->full_name);
        $sheet->setCellValue('C2', $employee->unit->name);

        foreach($offset as $off) {
            $sheet->setCellValue('A'.$cell, $off->date->format('F d, Y'));
            $sheet->setCellValue('B'.$cell, $off->time);
            $sheet->setCellValue('C'.$cell, $off->hours);
            $sheet->setCellValue('D'.$cell, $off->approval == 1 ? 'Approved' : ($off->approval == 0 ? 'Pending' : 'Disapproved'));
            $sheet->setCellValue('E'.$cell, $off->created_at->format('F d, Y'));
            $cell++;
        }
    }
}
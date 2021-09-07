<?php

namespace hrmis\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use View;
use Input;
use Session;
use Image;
use Validator;

use hrmis\Models\Employee;
use hrmis\Models\User;
use hrmis\Models\Role;
use hrmis\Models\Group;
use hrmis\Models\Attendance;
use hrmis\Models\EmployeeStatus;

class api_UsersController extends Controller
{

    public function query(Request $request)
    {

        $roles = Role::orderBy("name")->get();
        $groups = Group::orderBy("name")->get();
        $status = EmployeeStatus::orderBy("name")->get();

        $q = '';
        $page = 0;
        $limit = 0;

        if ($request->has('page')){
            $page = $request->input('page');
        }

        if ($request->has('limit')){
            $limit = $request->input('limit');
        }

        if ($request->has('q')){
            $q = $request->input('q');
        }

        $skip = $page * $limit;

        $count = Employee::count();

        $count;
        $pages = 0;

        try{
            if ($count > 0 && $limit > 0){
                $pages = intdiv($count, $limit);
            } else {
                $pages = 0;
            }
        } catch (Exception $e){
            $pages = 0;
        }

        if ($page > $pages){
            $page = 1;
            $skip = 0;
        }

        if ($count > 0 && $limit > 0){
            if ($count % $limit > 0){
                $pages++;
            }
        }


        $rows;

        if ($limit == 0){
            if (strlen($q) > 0) {
                $rows = Employee::where('first_name', 'LIKE' , '%'.$q.'%')->orWhere('middle_name', 'LIKE', '%'.$q.'%')->orWhere('last_name', 'LIKE', '%'.$q.'%')->orderBy('first_name', 'ASC')->get();
            } else {
                $rows = Employee::orderBy('first_name', 'ASC')->get();
            }       
        } else {
            if (strlen($q) > 0) {
                $rows = Employee::where('first_name', 'LIKE' , '%'.$q.'%')->orWhere('middle_name', 'LIKE', '%'.$q.'%')->orWhere('last_name', 'LIKE', '%'.$q.'%')->skip($skip)->take($limit)->orderBy('first_name', 'ASC')->get();
            } else {
                $rows = Employee::orderBy('first_name', 'ASC')->skip($skip)->take($limit)->get();
            }       
        }
        return view('api.employees', compact('rows', 'q', 'count' , 'pages', 'page', 'roles', 'groups', 'status'));
    }

    public function showSignature($id)
    {
        $emp           = Employee::find($id);
        if (!$emp) return null;
        if($emp->signature != NULL) {
            $storage_path   = storage_path('dost/employee_signature/'.$emp->signature);
            $image          = Image::make($storage_path)->response();
            return $image;
        }
        else {
            return null;
        }
    }

    public function showPicture($id)
    {
        $emp           = Employee::find($id);
        if (!$emp) return null;

        if($emp->picture != NULL) {
            $storage_path   = storage_path('app/public/profile/'.$emp->picture);
            $image          = Image::make($storage_path)->response();
            return $image;
        }
        else {
            return null;
        }
    }

    public function save(Request $request, $id)
    {

        $row = new Employee();
        
        if($id > 0) {
            $row = Employee::find($id);
            if (!$row){
                return '-2'; // Record not found
            }
        }

        $input = $request->all();
        $attr = [
            'username' => 'Username',
        ];

        $rules = [
            'username' => 'unique:employees,username,'.$id.',id',
        ];

        $val = Validator::make($input, $rules);
        $val->setAttributeNames($attr);

        if ($val->fails()){
            return '-1';  // Duplicate username
        } 

        $row->first_name = $request->input('first_name');
        $row->middle_name = $request->input('middle_name');
        $row->last_name = $request->input('last_name');
        $row->name_suffix = $request->input('name_suffix');
        $row->designation = $request->input('designation');
        $row->username = $request->input('username');

        if ($request->has('password')){
            $row->password = $request->input('password');
        }
        if ($request->has('is_active')){
            $row->is_active = $request->input('is_active');
        }
        if ($request->has('is_admin')){
            $row->is_admin = $request->input('is_admin');
        }

        if($request->hasFile('picture')) {
            $extension = $request->file('picture')->getClientOriginalExtension();
            $request->file('picture')->move(base_path('storage/app/public/profile/'), $row->username.".".$extension);
            $row->picture = $request->username.".".$extension;
        }

        if($request->hasFile('signature')) {
            $extension = $request->file('signature')->getClientOriginalExtension();
            $request->file('signature')->move(base_path('storage/dost/employee_signature/'), $row->username.".".$extension);
            $row->signature = $row->username.".".$extension;
        }

        $row->save();

        return $row->id;
    }

    public function delete($id)
    {
        $emp = Employee::find($id);
        if (!$emp) return '0';
        $emp->is_active = 0;
        $emp->save();
        $msg = '';
        return '1';
    }

    public function activate($id)
    {
        $emp = Employee::find($id);
        if (!$emp) return '0';
        $emp->is_active = 1;
        $emp->save();
        $msg = '';
        return '1';
    }

    public function login(Request $request)
    {
        if (!$request->has('username')) return '5';
        if (!$request->has('password')) return '6';
        $empdata = array(
                'username'    => $request->get('username'),
                'password'      => $request->get('password'),
                'is_active'     => 1,
                'is_admin'          => 1
            );
        if(Auth::attempt($empdata)) {
            return '1';
        }
        return '0';
    }

    public function attendance(Request $request, $id){
        $emp = Employee::find($id);
        if (!$emp) return '0';

        $date =  date("Y-m-d");

        $where = "(employee_id = ?) AND (DATE_FORMAT(time_in, '%Y-%m-%d') = ?) AND (ISNULL(time_out))";
        $values = array();
        $values[] = $id;
        $values[] = $date;

        $row = Attendance::whereRaw($where, $values)->first();
        if (!$row){
            $row = new Attendance();
            $row->employee_id = $id;
            $row->time_in = date("Y-m-d H:i:s");
            $row->time_out = NULL;
        } else {
            $row->time_out = date("Y-m-d H:i:s");
        }
        $row->save();

        return redirect("/api/dtr/$id");
    }

    public function desktop_time_in(Request $request, $id, $location = null) {
        $emp = Employee::find($id);
        if (!$emp) return '0';

        $date =  date("Y-m-d");

        $where = "(employee_id = ?) AND (DATE_FORMAT(time_in, '%Y-%m-%d') = ?) AND (ISNULL(time_out))";
        $values = array();
        $values[] = $id;
        $values[] = $date;

        $row = Attendance::whereRaw($where, $values)->first();
        if (!$row){
            $row = new Attendance();
            $row->employee_id = $id;
            $row->time_in = date("Y-m-d H:i:s");
            $row->time_out = NULL;
            $row->location = $location;
            $row->ip_address = $request->getClientIp();
        } else {
            $row->time_out = date("Y-m-d H:i:s");
            $row->ip_address = $request->getClientIp();
        }
        $row->save();

        return redirect()->back();
    }

    public function dtr(Request $request, $id){
        $emp = Employee::find($id);
        if (!$emp) return '0';
        $date = date("Y-m-d");
        $yr = date("Y");
        $mo = date("n");

        $where = "(employee_id = ?) AND (YEAR(time_in) = ?) AND (MONTH(time_in) = ?)";
        $values = array();
        $values[] = $id;
        $values[] = $yr;
        $values[] = $mo;

        $rows = Attendance::whereRaw($where, $values)->orderBy('time_in', 'ASC')->get();
        return view('attendance.kioskdtr', compact('date', 'id', 'emp', 'rows'));
    }

    public function checkusername(Request $request, $id = 0){
        if (!$request->has('username')) return '2';
        $emp = null;
        if ($id == 0){
            $emp = Employee::where('username', $request->input('username'))->first();
        } else {
            $emp = Employee::where('username', $request->input('username'))->where('id', $id)->first();
        }
        if (!$emp) return '1';
        return '0';
    }

    public function reset_password($id)
    {
        $emp = Employee::find($id);
        $emp->password = 'dostcalabarzon';
        $emp->save();
        Session::put('alert_type', 'alert-success');
        return redirect('users')->with('message', 'Password successfully updated.');
    }
}

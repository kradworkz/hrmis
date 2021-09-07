@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Employees') }}"><small class="text-primary font-weight-bold">Employees</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="font-weight-bold text-muted">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Save Employee', ['id' => $id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="card">
                            <h6 class="card-header bg-secondary text-white rounded-0">
                                <div class="d-flex align-items-center">
                                    <small class="float-left mx-auto w-100">Personal Information</small>
                                </div>
                            </h6>
                            <div class="card-body">
								<div class="form-group row">
									<div class="col-md-4">
										<label for="first_name">First Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('first_name') }}</i></label>
										<input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" id="first_name" class="form-control form-control-sm">
									</div>
									<div class="col-md-4">
										<label for="middle_name">Middle Name <i class="text-danger font-weight-bold">{{ $errors->first('middle_name') }}</i></label>
										<input type="text" name="middle_name" value="{{ old('middle_name', $employee->middle_name) }}" id="middle_name" class="form-control form-control-sm">
									</div>
									<div class="col-md-4">
										<label for="last_name">Last Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('last_name') }}</i></label>
										<input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" id="last_name" class="form-control form-control-sm">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-6">
										<label for="email">Email Address </label>
										<input type="text" name="email" value="{{ old('email', $employee->email) }}" id="email" class="form-control form-control-sm">
									</div>
									<div class="col-md-6">
										<label for="contact_no">Contact no </label>
										<input type="text" name="contact_no" value="{{ old('contac_no', $employee->contact_no) }}" id="contact_no" class="form-control form-control-sm">
									</div>
								</div>
								<div class="form-group">
									<label for="designation">Designation <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('designation') }}</i></label>
									<input type="text" name="designation" value="{{ old('designation', $employee->designation) }}" id="designation" class="form-control form-control-sm">
								</div>
								<div class="form-group">
									<label for="employee_status_id">Employment Status <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('employee_status_id') }}</i></label>
									<select name="employee_status_id" id="employee_status_id" class="form-control form-control-sm">
										@foreach($emp_status as $status)
											<option value="{{ $status->id }}" {{ old('employee_status_id', $employee->employee_status_id == $status->id ? 'selected' : '') }}>{!! $status->name !!}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group row">
									<div class="col-md-6">
										<label for="picture">Profile Picture <i class="text-danger font-weight-bold">{{ $errors->first('picture') }}</i></label>
										<input type="file" name="picture" multiple class="form-control-file">
									</div>
									<div class="col-md-6">
										<label for="signature">Signature <i class="text-danger font-weight-bold">{{ $errors->first('signature') }}</i></label>
										<input type="file" name="signature" multiple class="form-control-file">
									</div>
								</div>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <h6 class="card-header bg-secondary text-white rounded-0"><small>Account Information</small></h6>
                            <div class="card-body">
								<div class="form-group">
									<label for="username">Username <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('username') }}</i></label>
									<input type="text" name="username" value="{{ old('username', $employee->username) }}" id="username" class="form-control form-control-sm">
								</div>
								<div class="form-group">
									<label for="password">Password <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('password') }}</i></label>
									<input type="password" name="password" id="password" class="form-control form-control-sm">
								</div>
								<div class="form-group">
									<label for="password_confirmation">Confirm Password <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('password_confirmation') }}</i></label>
									<input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-sm">
								</div>
								<div class="form-group row">
									<div class="col-md-6">
										<label for="role_id">Role(s) <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('role_id') }}</i></label>
										<select name="role_id[]" id="role_id" class="chosen-select form-control" multiple data-placeholder="DOST IV-A Personnel">
											@foreach($roles as $role)
												<option value="{!! $role->id !!}" {{ collect(old('role_id', $employee->roles->pluck('id') ?? []))->contains($role->id) ? 'selected' : '' }}>{!! $role->name !!}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-6">
										<label for="unit_id">Unit <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('unit_id') }}</i></label>
										<select name="unit_id" id="unit_id" class="form-control form-control-sm">
											@foreach($units as $unit)
												<option value="{{ $unit->id }}" {{ old('unit_id', $employee->unit_id) == $unit->id ? 'selected' : '' }}>{!! $unit->name !!}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group mb-0">
	                                <input type="submit" name="Save" class="btn btn-primary btn-sm btn-block">
	                            </div>
                            </div>
                        </div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<br>
	@endsection
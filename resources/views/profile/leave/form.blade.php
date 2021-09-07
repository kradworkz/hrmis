@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Leave') }}"><small class="text-primary font-weight-bold">Profile</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Leave', ['id' => $id]) }}" id="leaveForm" method="POST" autocomplete="off">
						{{ csrf_field() }}
						<div class="form-group row">
							<div class="col-md-4">
								<label for="start_date">Start Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('start_date') }}</i></label>
								<input type="text" name="start_date" value="{{ old('start_date', $leave->start_date == null ? '' : $leave->start_date->format('m/d/Y')) }}" id="start_date" class="form-control form-control-sm">
							</div>
							<div class="col-md-4">
								<label for="end_date">End Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('end_date') }}</i></label>
								<input type="text" name="end_date" value="{{ old('end_date', $leave->end_date == null ? '' : $leave->end_date->format('m/d/Y')) }}" id="end_date" class="form-control form-control-sm">
							</div>
							<div class="col-md-4">
								<label for="time">Time <i class="text-info font-weight-bold">(For Filing Half Day Leave)</i></label>
								<select name="time" id="time" class="form-control form-control-sm" disabled required>
									<option value="">-- Select Option --</option>
									<option value="Whole Day" {{ old('time', $leave->time) == 'Whole Day' ? 'selected' : '' }}>Whole Day</option>
									<option value="AM" {{ old('time', $leave->time) == 'AM' ? 'selected' : '' }}>AM</option>
									<option value="PM" {{ old('time', $leave->time) == 'PM' ? 'selected' : '' }}>PM</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-2">
								<label for="type">Type of Leave <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('type') }}</i></label>
							</div>
							<div class="col-md-5">
								<label>Select Option <span class="text-danger">*</span></label>
							</div>
							<div class="col-md-5">
								<label>Others (Specify)</label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-2">
								<div class="form-check form-check">
							        <input class="form-check-input" type="radio" name="type" id="vacation_leave" value="Vacation Leave" required>
							        <label class="form-check-label mt-1" for="vacation_leave">Vacation Leave</label>
							    </div>
							</div>
							<div class="col-md-5">
								<select name="vacation_leave" id="vl_specify" class="form-control form-control-sm" disabled required>
									<option value="">-- Select Option --</option>
									<option value="Vacation Leave">Vacation Leave</option>
									<option value="Mandatory Leave">Mandatory Leave</option>
									<option value="Parental Leave">Parental Leave</option>
									<option value="Others">Others</option>
								</select>
							</div>
							<div class="col-md-5">
								<input type="text" name="vacation_leave_specify" id="vacation_leave_specify" class="form-control form-control-sm" disabled required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-5 offset-md-2">
								<div><label>In case of Vacation Leave</label></div>
								<div class="form-check form-check-inline">
	                                <input class="form-check-input vl_location" type="radio" name="vacation_location" id="within_ph" value="Within Philippines" required disabled>
	                                <label class="form-check-label" for="within_ph">Within Philippines</label>
	                            </div>
	                            <div class="form-check form-check-inline">
	                                <input class="form-check-input vl_location" type="radio" name="vacation_location" id="abroad" value="Abroad" required disabled>
	                                <label class="form-check-label" for="abroad">Abroad</label>
	                            </div>
							</div>
							<div class="col-md-5">
								<label for="vacation_location_specify">Specify</label>
								<input type="text" name="vacation_location_specify" id="vacation_location_specify" class="form-control form-control-sm" required disabled>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-2">
								<div class="form-check form-check">
							        <input class="form-check-input" type="radio" name="type" id="sick_leave" value="Sick Leave" required>
							        <label class="form-check-label mt-1" for="sick_leave">Sick Leave</label>
							    </div>
							</div>
							<div class="col-md-5">
								<select name="sick_leave" id="sl_specify" class="form-control form-control-sm" disabled required>
									<option value="">-- Select Option --</option>
									<option value="Sick Leave">Sick Leave</option>
									<option value="Maternity Leave">Maternity Leave</option>
									<option value="Rehabilitation Leave">Rehabilitation Leave</option>
									<option value="Others">Others</option>
								</select>
							</div>
							<div class="col-md-5">
								<input type="text" name="sick_leave_specify" id="sick_leave_specify" class="form-control form-control-sm" disabled>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-5 offset-md-2">
								<div><label>In case of Sick Leave</label></div>
								<div class="form-check form-check-inline">
	                                <input class="form-check-input sl_location" type="radio" name="sick_location" id="in_hosp" value="In Hospital" required disabled>
	                                <label class="form-check-label" for="in_hosp">In Hospital</label>
	                            </div>
	                            <div class="form-check form-check-inline">
	                                <input class="form-check-input sl_location" type="radio" name="sick_location" id="out_patient" value="Out Patient" required disabled>
	                                <label class="form-check-label" for="out_patient">Out Patient</label>
	                            </div>
							</div>
							<div class="col-md-5">
								<label for="sick_location_specify">Specify</label>
								<input type="text" name="sick_location_specify" id="sick_location_specify" class="form-control form-control-sm" required disabled>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<div class="form-check form-check">
							        <input class="form-check-input" type="radio" name="type" id="spl" value="Special Privilege Leave" required>
							        <label class="form-check-label mt-1" for="spl">Special Privilege Leave</label>
							    </div>
							</div>
						</div>
						<div class="form-group">
							<label for="commutation">Commutation</label>
							<select name="commutation" class="form-control form-control-sm">
								<option value="Requested">Requested</option>
								<option value="Not Requested">Not Requested</option>
							</select>
						</div>
						<br>
						@if(Auth::user()->leave_credits)
						<table class="table table-sm table-bordered table-hover mb-0">
							<thead>
								<tr>
									<th colspan="3" class="text-center">
										Certification of Leave Credits: as of <i class="text-primary font-weight-bold">{!! date("F", mktime(0, 0, 0, Auth::user()->leave_credits->month, 10)) !!} {!! Auth::user()->leave_credits->year !!}</i>
									</th>
								</tr>
								<tr>
									<th width="33%" class="text-center">Vacation</th>
									<th width="33%" class="text-center">Sick</th>
									<th width="33%" class="text-center">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="33%" class="text-center">{!! Auth::user()->leave_credits->vl_balance !!}</td>
									<td width="33%" class="text-center">{!! Auth::user()->leave_credits->sl_balance !!}</td>
									<td width="33%" class="text-center">{!! Auth::user()->leave_credits->vl_balance+Auth::user()->leave_credits->sl_balance !!}</td>
								</tr>
							</tbody>
						</table>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-body py-3 px-4">
						@include('layouts.comment', ['comments' => $leave])
					</div>
					<div class="card-footer rounded-0">
						<div class="form-group">
                            <label for="commentBox">Comment</label>
                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Leave') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
					</form>
				</div>
			</div>
		</div>
	@endsection
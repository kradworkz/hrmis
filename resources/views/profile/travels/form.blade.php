@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Travel Order') }}"><small class="text-primary font-weight-bold">Profile</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Travel Order', ['id' => $id]) }}" id="travelOrder" method="POST" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group row">
							<div class="col-md-6">
								<label for="start_date">Start Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('start_date') }}</i></label>
								<input type="text" name="start_date" value="{{ old('start_date', $travel->start_date == null ? '' : $travel->start_date->format('m/d/Y')) }}" id="start_date" class="form-control form-control-sm">
							</div>
							<div class="col-md-6">
								<label for="end_date">End Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('end_date') }}</i></label>
								<input type="text" name="end_date" value="{{ old('end_date', $travel->end_date == null ? '' : $travel->end_date->format('m/d/Y')) }}" id="end_date" class="form-control form-control-sm">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label for="time">Time of Departure <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time') }}</i></label>
								<input type="time" name="time" value="{{ old('time', $travel->time) }}" id="time" class="form-control form-control-sm">
							</div>
							<div class="col-md-6">
								<label for="time_mode">Time <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time_mode') }}</i></label>
								<select name="time_mode" id="time_mode" class="form-control form-control-sm">
									<option value="Whole Day" {{ old('time_mode', $travel->time_mode) == 'Whole Day' ? 'selected' : '' }}>Whole Day</option>
									<option value="AM" {{ old('time_mode', $travel->time_mode) == 'AM' ? 'selected' : '' }}>AM</option>
									<option value="PM" {{ old('time_mode', $travel->time_mode) == 'PM' ? 'selected' : '' }}>PM</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="travel_passengers">Employees <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('travel_passengers') }}</i></label>
							<select name="travel_passengers[]" id="travel_passengers" class="chosen-select form-control" multiple data-placeholder="DOST IV-A Personnel">
								@foreach($employees as $employee)
									<option value="{!! $employee->id !!}" {{ collect(old('travel_passengers', $travel->travel_passengers->pluck('id') ?? []))->contains($employee->id) ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="destination">Destination <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('destination') }}</i></label>
							<textarea name="destination" id="destination" class="form-control form-control-sm rounded-0" rows="3">{{ old('destination', $travel->destination) }}</textarea>
						</div>
						<div class="form-group">
							<label for="mode_of_travel">Mode of Travel <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('mode_of_travel') }}</i></label>
							<select name="mode_of_travel" id="mode_of_travel" class="form-control form-control-sm">
								<option value="DOST Vehicle" {{ old('mode_of_travel', $travel->mode_of_travel) == 'DOST Vehicle' ? 'selected' : '' }}>DOST Vehicle</option>
								<option value="Public Conveyance" {{ old('mode_of_travel', $travel->mode_of_travel) == 'Public Conveyance' ? 'selected' : '' }}>Public Conveyance</option>
								<option value="Van Rental" {{ old('mode_of_travel', $travel->mode_of_travel) == 'Van Rental' ? 'selected' : '' }}>Van Rental</option>
							</select>
						</div>
						<div class="form-group">
							<label for="purpose">Purpose <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('purpose') }}</i></label>
							<textarea name="purpose" id="purpose" class="form-control form-control-sm rounded-0" rows="3">{{ old('purpose', $travel->purpose) }}</textarea>
						</div>
						<div class="form-group">
							<label for="remarks">Remarks</label>
							<textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0" rows="3">{{ old('remarks', $travel->remarks) }}</textarea>
						</div>
						@include('layouts.travel')
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-body py-3 px-4">
						@include('layouts.comment', ['comments' => $travel])
					</div>
					<div class="card-footer rounded-0">
						<div class="form-group">
                            <label for="commentBox">Comment</label>
                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Travel Order') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
					</form>
				</div>
			</div>
		</div>
	@endsection
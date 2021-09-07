@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Vehicle Reservation') }}"><small class="text-primary font-weight-bold">Profile</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Comment', ['id' => $id, 'module' => 1]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group row">
							<div class="col-md-4">
								<label for="start_date">Start Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('start_date') }}</i></label>
								<input type="text" name="start_date" value="{{ old('start_date', $reservation->start_date == null ? '' : $reservation->start_date->format('m/d/Y')) }}" id="start_date" class="form-control form-control-sm" {{ $id != 0 ? 'disabled' : '' }}>
							</div>
							<div class="col-md-4">
								<label for="end_date">End Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('end_date') }}</i></label>
								<input type="text" name="end_date" value="{{ old('end_date', $reservation->end_date == null ? '' : $reservation->end_date->format('m/d/Y')) }}" id="end_date" class="form-control form-control-sm" {{ $id != 0 ? 'disabled' : '' }}>
							</div>
							<div class="col-md-4">
								<label for="vehicle_id">Vehicle <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('vehicle_id') }}</i></label>
								<input type="text" name="vehicle_id" value="{{ old('vehicle_id', $reservation->vehicle_id) }}" id="vehicle_id" hidden>
								<input type="text" name="plate_number" value="{{ old('plate_number', $reservation->vehicle == null ? '' : $reservation->vehicle->plate_number) }}" id="plate_number" class="form-control form-control-sm" disabled>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="time">Time of Departure <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time') }}</i></label>
								<input type="text" name="time" value="{{ old('time', $reservation->time) }}" id="time" class="form-control form-control-sm" disabled>
							</div>
						</div>
						<div class="form-group">
							<label for="passengers">Employees <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('passengers') }}</i></label>
							<select name="passengers[]" id="passengers" class="chosen-select form-control" multiple data-placeholder="DOST IV-A Personnel" disabled>
								@foreach($employees as $employee)
									<option value="{!! $employee->id !!}" {{ collect(old('passengers', $reservation->passengers->pluck('id') ?? []))->contains($employee->id) ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="destination">Destination <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('destination') }}</i></label>
							<textarea name="destination" id="destination" class="form-control form-control-sm rounded-0" rows="3" disabled>{{ old('destination', $reservation->destination) }}</textarea>
						</div>
						<div class="form-group">
							<label for="purpose">Purpose <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('purpose') }}</i></label>
							<textarea name="purpose" id="purpose" class="form-control form-control-sm rounded-0" rows="3" disabled>{{ old('purpose', $reservation->purpose) }}</textarea>
						</div>
						<div class="form-group">
							<label for="remarks">Remarks</label>
							<textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0" rows="3" disabled>{{ old('remarks', $reservation->remarks) }}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-body py-3 px-4">
						@include('layouts.comment', ['comments' => $reservation])
					</div>
					<div class="card-footer rounded-0">
						<div class="form-group">
                            <label for="commentBox">Comment</label>
                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Vehicle Reservation') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
					</form>
				</div>
			</div>
		</div>
		<br>
		<link href="{{ asset('tools/jquery-datepicker/jquery-ui.min.css') }}" rel="stylesheet">
		<link href="{{ asset('tools/chosen/chosen.min.css') }}" rel="stylesheet">
		<script src="{{ asset('tools/jquery-datepicker/jquery-ui.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('tools/chosen/chosen.jquery.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('scripts/reservations.js') }}" type="text/javascript"></script>
	@endsection
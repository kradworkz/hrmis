@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Vehicle Reservation') }}">Profile</a> <i class="fa fa-angle-double-right fa-xs"></i> {{ Route::currentRouteName() }}</h6>
					<div class="card-body">
						<form action="{{ route('Submit Reservation', ['id' => $id]) }}" id="vehicleReservation" method="POST" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div id="route" value="{{ route('Get Vehicles') }}" hidden></div>
						<div class="form-group row">
							<div class="col-md-4">
								<label for="start_date">Start Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('start_date') }}</i></label>
								<input type="text" name="start_date" id="start_date" value="{{ old('start_date', $reservation->start_date == null ? '' : $reservation->start_date->format('m/d/Y')) }}" class="form-control form-control-sm" {{ $id != 0 ? 'disabled' : '' }}>
							</div>
							<div class="col-md-4">
								<label for="end_date">End Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('end_date') }}</i></label>
								<input type="text" name="end_date" id="end_date" value="{{ old('end_date', $reservation->end_date == null ? '' : $reservation->end_date->format('m/d/Y')) }}" class="form-control form-control-sm" {{ $id != 0 ? 'disabled' : '' }}>
							</div>
							<div class="col-md-4">
								<label for="vehicle_id">Vehicle <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('vehicle_id') }}</i></label>
								<input type="text" name="vehicle_id" value="{{ old('vehicle_id', $reservation->vehicle_id) }}" id="vehicle_id" hidden>
								<input type="text" name="plate_number" value="{{ old('plate_number', $reservation->vehicle == null ? '' : $reservation->vehicle->plate_number) }}" id="plate_number" class="form-control form-control-sm" readonly>
							</div>
						</div>
						<div class="form-group">
							<div class="row" id="vehicle_label" hidden="true">
								<div class="col-md-12">
									<label>Select Vehicle <span class="text-danger">*</span></label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12" id="vehicles"></div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="time">Time of Departure <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time') }}</i></label>
								<input type="time" name="time" value="{{ old('time', $reservation->time) }}" id="time" class="form-control form-control-sm">
							</div>
						</div>
						<div class="form-group">
							<label for="passengers">Employees <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('passengers') }}</i></label>
							<select name="passengers[]" id="passengers" class="chosen-select form-control" multiple data-placeholder="DOST IV-A Personnel">
								@foreach($employees as $employee)
									<option value="{!! $employee->id !!}" {{ collect(old('passengers', $reservation->passengers->pluck('id') ?? []))->contains($employee->id) ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="destination">Destination <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('destination') }}</i></label>
							<textarea name="destination" id="destination" class="form-control form-control-sm rounded-0" rows="3">{{ old('destination', $reservation->destination) }}</textarea>
						</div>
						<div class="form-group">
							<label for="purpose">Purpose <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('purpose') }}</i></label>
							<textarea name="purpose" id="purpose" class="form-control form-control-sm rounded-0" rows="3">{{ old('purpose', $reservation->purpose) }}</textarea>
						</div>
						<div class="form-group">
							<label for="remarks">Remarks</label>
							<textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0" rows="3">{{ old('remarks', $reservation->remarks) }}</textarea>
						</div>
						@if(Auth::user()->unit->location == 0)
							<div class="form-group">
								<label for="driver_name">Driver <span class="text-danger">*</span></label>
								<input type="text" name="driver_name" value="{{ old('driver_name', $reservation->driver_name) }}" id="driver_name" class="form-control form-control-sm" required>
							</div>
							<div class="custom-control custom-checkbox">
	  							<input type="checkbox" name="location" class="custom-control-input" value="1" {{ old('location', $reservation->location) == 1 ? 'checked' : '' }} id="location">
	  							<label class="custom-control-label" for="location">Within Province</label>
							</div>
						@endif
						@if($id == 0)
						<div class="form-group">
							<div class="custom-control custom-checkbox">
	  							<input type="checkbox" name="travel_order" class="custom-control-input" id="travel_order">
	  							<label class="custom-control-label" for="travel_order">Include Travel Order</label>
							</div>
						</div>
						<div class="form-group">
							<label></label>
						</div>
						<div id="include"></div>
						@endif
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
	@endsection
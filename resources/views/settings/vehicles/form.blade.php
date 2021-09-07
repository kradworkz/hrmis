@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('settings.nav')
					<div class="card-body">
						<form action="{{ route('Submit Vehicle', ['id' => $id]) }}" method="POST" autocomplete="off">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="plate_number">Plate Number: <strong class="text-danger">*</strong></label>
								<input type="text" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" class="form-control form-control-sm" required>
							</div>
							<div class="form-group">
								<label for="equipment_name">Equipment Name:</label>
								<input type="text" name="equipment_name" value="{{ old('equipment_name', $vehicle->equipment_name) }}" class="form-control form-control-sm">
							</div>
							<div class="form-group">
								<label for="code_number">Code Number:</label>
								<input type="text" name="code_number" value="{{ old('code_number', $vehicle->code_number) }}" class="form-control form-control-sm">
							</div>
							<div class="form-group">
								<label for="model_number">Model Number:</label>
								<input type="text" name="model_number" value="{{ old('model_number', $vehicle->model_number) }}" class="form-control form-control-sm">
							</div>
							<div class="form-group">
								<label for="serial_number">Serial Number:</label>
								<input type="text" name="serial_number" value="{{ old('serial_number', $vehicle->serial_number) }}" class="form-control form-control-sm">
							</div>
							<div class="form-group">
								<label for="vehicle_type">Vehicle Type:</label>
								<input type="text" name="vehicle_type" value="{{ old('vehicle_type', $vehicle->vehicle_type) }}" class="form-control form-control-sm">
							</div>
							<div class="form-group">
								<label for="remarks">Remarks:</label>
								<input type="text" name="remarks" value="{{ old('remarks', $vehicle->remarks) }}" class="form-control form-control-sm">
							</div>
							<div class="form-group">
								<label for="group_id">Group: <strong class="text-danger">*</strong></label>
								<select class="form-control form-control-sm rounded-0" name="group_id">
									@foreach($groups as $group)
										<option value="{{ $group->id }}">{!! $group->name !!}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="location">Location:</label>
								<div class="custom-control custom-radio">
									<input type="radio" name="location" value="1" {{ old('location', $vehicle->location == '1' ? 'checked' : '') }} class="custom-control-input" id="regional">
									<label class="custom-control-label" for="regional">Regional Office</label>
								</div>
								<div class="custom-control custom-radio">
									<input type="radio" name="location" value="0" {{ old('location', $vehicle->location == '0' ? 'checked' : '') }} class="custom-control-input" id="provincial">
									<label class="custom-control-label" for="provincial">Provincial Office</label>
								</div>
							</div>
							<div class="form-group">
								<label for="is_active">Status:</label>
								<div class="custom-control custom-radio">
									<input type="radio" name="is_active" value="1" {{ old('is_active', $vehicle->is_active == '1' ? 'checked' : '') }} class="custom-control-input" id="active">
									<label class="custom-control-label" for="active">Active</label>
								</div>
								<div class="custom-control custom-radio">
									<input type="radio" name="is_active" value="0" {{ old('is_active', $vehicle->is_active == '0' ? 'checked' : '') }} class="custom-control-input" id="inactive">
									<label class="custom-control-label" for="inactive">Inactive</label>
								</div>
							</div>
							<div class="form-group pt-2 mb-1">
	                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
	                            <a href="{{ route('Vehicles') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
	                        </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endsection
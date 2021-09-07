@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Travel Order') }}"><small class="text-primary font-weight-bold">Profile</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Comment', ['id' => $id, 'module' => 2]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="start_date">Start Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('start_date') }}</i></label>
							<input type="text" name="start_date" value="{{ old('start_date', $travel->start_date == null ? '' : $travel->start_date->format('m/d/Y')) }}" id="start_date" class="form-control form-control-sm" disabled>
						</div>
						<div class="form-group">
							<label for="end_date">End Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('end_date') }}</i></label>
							<input type="text" name="end_date" value="{{ old('end_date', $travel->end_date == null ? '' : $travel->end_date->format('m/d/Y')) }}" id="end_date" class="form-control form-control-sm" disabled>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label for="time">Time of Departure <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time') }}</i></label>
								<input type="text" name="time" value="{{ old('time', $travel->time) }}" id="time" class="form-control form-control-sm" disabled>
							</div>
							<div class="col-md-6">
								<label for="time_mode">Time <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time_mode') }}</i></label>
								<select name="time_mode" id="time_mode" class="form-control form-control-sm" disabled>
									<option value="Whole Day" {{ old('time_mode', $travel->time_mode) == 'Whole Day' ? 'selected' : '' }}>Whole Day</option>
									<option value="AM" {{ old('time_mode', $travel->time_mode) == 'AM' ? 'selected' : '' }}>AM</option>
									<option value="PM" {{ old('time_mode', $travel->time_mode) == 'PM' ? 'selected' : '' }}>PM</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="travel_passengers">Employees <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('travel_passengers') }}</i></label>
							<select name="travel_passengers[]" id="travel_passengers" class="chosen-select form-control" multiple data-placeholder="DOST IV-A Personnel" disabled>
								@foreach($employees as $employee)
									<option value="{!! $employee->id !!}" {{ collect(old('travel_passengers', $travel->travel_passengers->pluck('id') ?? []))->contains($employee->id) ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="destination">Destination <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('destination') }}</i></label>
							<textarea name="destination" id="destination" class="form-control form-control-sm rounded-0" rows="3" disabled>{{ old('destination', $travel->destination) }}</textarea>
						</div>
						<div class="form-group">
							<label for="mode_of_travel">Mode of Travel <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('mode_of_travel') }}</i></label>
							<select name="mode_of_travel" id="mode_of_travel" class="form-control form-control-sm" disabled>
								<option value="DOST Vehicle" {{ old('mode_of_travel', $travel->mode_of_travel) == 'DOST Vehicle' ? 'selected' : '' }}>DOST Vehicle</option>
								<option value="Public Conveyance" {{ old('mode_of_travel', $travel->mode_of_travel) == 'Public Conveyance' ? 'selected' : '' }}>Public Conveyance</option>
								<option value="Van Rental" {{ old('mode_of_travel', $travel->mode_of_travel) == 'Van Rental' ? 'selected' : '' }}>Van Rental</option>
							</select>
						</div>
						<div class="form-group">
							<label for="purpose">Purpose <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('purpose') }}</i></label>
							<textarea name="purpose" id="purpose" class="form-control form-control-sm rounded-0" rows="3" disabled>{{ old('purpose', $travel->purpose) }}</textarea>
						</div>
						<div class="form-group">
							<label for="remarks">Remarks</label>
							<textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0" rows="3" disabled>{{ old('remarks', $travel->remarks) }}</textarea>
						</div>
						<div class="form-group">
							<label for="travel_documents[]">Travel Documents <i class="text-danger font-weight-bold">{{ $errors->first('document_path.*') }}</i></label>
							<input type="file" name="document_path[]" multiple class="form-control-file">
						</div>
						<div class="form-group row">
							<div class="col-md-12 text-center"><h5>Travel Expenses</h5></div>
						</div>
						<div class="form-group row">
							<div class="col-md-3 offset-md-3">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="fund_label" id="general_funds" class="custom-control-input" disabled>
                                    <label class="custom-control-label align-text" for="general_funds">General Funds</label>
                                </div>
							</div>
							<div class="col-md-3">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="fund_label" id="project_funds" class="custom-control-input" disabled>
                                    <label class="custom-control-label align-text" for="project_funds">Project Funds</label>
                                </div>
							</div>
							<div class="col-md-3">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="fund_label" id="others" class="custom-control-input" disabled>
                                    <label class="custom-control-label align-text" for="others">Others</label>
                                </div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12 text-center"><h5>Actual</h5></div>
						</div>
						@foreach($expenses as $key => $expense)
							@if($loop->iteration == 3)
							<div class="form-group row">
								<div class="col-md-12 text-center"><h5>Per Diem</h5></div>
							</div>
							@endif
							<div class="form-group row">
								<div class="col-md-3 text-right">
									{!! $expense->name !!}
								</div>
								<div class="col-md-3">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" name="expense_id[]" value="{{ $expense->id.',1' }}" {{ in_array($expense->id.',1', old('expense_id') ?? []) ? 'checked' : (in_array($expense->id.',1', $tfexpenses ?? []) ? 'checked' : '') }} id="{{ $expense->name.'-'.$expense->id.'-1' }}" class="custom-control-input general_funds" disabled>
	                                    <label class="custom-control-label" for="{{ $expense->name.'-'.$expense->id.'-1' }}"></label>
	                                </div>
								</div>
								<div class="col-md-3">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" name="expense_id[]" value="{{ $expense->id.',2' }}" {{ in_array($expense->id.',2', old('expense_id') ?? []) ? 'checked' : (in_array($expense->id.',2', $tfexpenses ?? []) ? 'checked' : '') }} id="{{ $expense->name.'-'.$expense->id.'-2' }}" class="custom-control-input project_funds" disabled>
	                                    <label class="custom-control-label" for="{{ $expense->name.'-'.$expense->id.'-2' }}"></label>
	                                </div>
								</div>
								
								<div class="col-md-3">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" name="expense_id[]" value="{{ $expense->id.',3' }}" {{ in_array($expense->id.',3', old('expense_id') ?? []) ? 'checked' : (in_array($expense->id.',3', $tfexpenses ?? []) ? 'checked' : '') }} id="{{ $expense->name.'-'.$expense->id.'-3' }}" class="custom-control-input others" disabled>
	                                    <label class="custom-control-label" for="{{ $expense->name.'-'.$expense->id.'-3' }}"></label>
	                                </div>
								</div>
							</div>
						@endforeach
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
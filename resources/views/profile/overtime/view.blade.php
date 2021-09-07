@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Overtime Request') }}"><small class="text-primary font-weight-bold">Profile</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Comment', ['id' => $id, 'module' => 4]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="start_date">Start Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('start_date') }}</i></label>
							<input type="text" name="start_date" value="{{ old('start_date', $overtime->start_date == null ? '' : $overtime->start_date->format('m/d/Y')) }}" id="start_date" class="form-control form-control-sm" disabled>
						</div>
						<div class="form-group">
							<label for="end_date">End Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('end_date') }}</i></label>
							<input type="text" name="end_date" value="{{ old('end_date', $overtime->end_date == null ? '' : $overtime->end_date->format('m/d/Y')) }}" id="end_date" class="form-control form-control-sm" disabled>
						</div>
						<div class="form-group">
							<label for="overtime_personnel">Employees <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('overtime_personnel') }}</i></label>
							<select name="overtime_personnel[]" id="overtime_personnel" class="chosen-select form-control" multiple data-placeholder="DOST IV-A Personnel" disabled>
								@foreach($employees as $employee)
									<option value="{!! $employee->id !!}" {{ collect(old('overtime_personnel', $overtime->overtime_personnel->pluck('id') ?? []))->contains($employee->id) ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="purpose">Purpose <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('purpose') }}</i></label>
							<textarea name="purpose" id="purpose" class="form-control form-control-sm rounded-0" rows="3" disabled>{{ old('purpose', $overtime->purpose) }}</textarea>
						</div>
						<div class="form-group mb-0">
							<label for="remarks">Remarks</label>
							<textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0" rows="3" disabled>{{ old('remarks', $overtime->remarks) }}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-body py-3 px-4">
						@include('layouts.comment', ['comments' => $overtime])
					</div>
					<div class="card-footer rounded-0">
						<div class="form-group">
                            <label for="commentBox">Comment</label>
                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Overtime Request') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
					</form>
				</div>
			</div>
		</div>
	@endsection
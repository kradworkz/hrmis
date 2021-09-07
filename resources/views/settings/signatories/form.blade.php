@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('settings.nav')
					<div class="card-body">
						<form action="{{ route('Submit Signatory', ['id' => $id]) }}" method="POST" autocomplete="off">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="employee_id">Employee: <strong class="text-danger">*</strong></label>
								<select name="employee_id" class="form-control form-control-sm">
									@foreach($employees as $employee)
										<option value="{{ $employee->id }}" {{ old('employee_id', $signatory->employee_id) == $employee->id ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="signatory">Signatory: <strong class="text-danger">*</strong></label>
								<select name="signatory" class="form-control form-control-sm">
									@foreach($roles as $key => $role)
										<option value="{{ $key }}" {{ old('signatory', $signatory->signatory) == $role ? 'selected' : '' }}>{!! $role !!}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="module_id">Module: <strong class="text-danger">*</strong></label>
								<select name="module_id" class="form-control form-control-sm">
									@foreach($modules as $module)
										<option value="{{ $module->id }}" {{ old('module_id', $signatory->module_id) == $module->id ? 'selected' : '' }}>{!! $module->name !!}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="groups">Groups <span class="text-danger">*</span></label>
								<select name="groups[]" class="chosen-select form-control" multiple data-placeholder="Groups">
									@foreach($groups as $group)
										<option value="{!! $group->id !!}" {{ collect(old('groups', $signatory->groups->pluck('id') ?? []))->contains($group->id) ? 'selected' : '' }}>{!! $group->name !!}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group pt-2 mb-1">
	                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
	                            <a href="{{ route('Signatory') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
	                        </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endsection
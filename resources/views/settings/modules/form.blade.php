@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('settings.nav')
					<div class="card-body">
						<form action="{{ route('Submit Module', ['id' => $id]) }}" method="POST" autocomplete="off">
							{{ csrf_field() }}
							<div class="form-group">
								<label>Name: </label>
								<label class="text-left">{!! $module->name !!}</label>
							</div>
							<div class="form-group">
								<label for="is_primary">Is Primary:</label>
								<div class="custom-control custom-radio">
									<input type="radio" name="is_primary" value="1" {{ old('is_primary', $module->is_primary == '1' ? 'checked' : '') }} class="custom-control-input" id="yes">
									<label class="custom-control-label" for="yes">Yes</label>
								</div>
								<div class="custom-control custom-radio">
									<input type="radio" name="is_primary" value="0" {{ old('is_primary', $module->is_primary == '0' ? 'checked' : '') }} class="custom-control-input" id="no">
									<label class="custom-control-label" for="no">No</label>
								</div>
							</div>
							<div class="form-group">
								<label for="is_active">Status:</label>
								<div class="custom-control custom-radio">
									<input type="radio" name="is_active" value="1" {{ old('is_active', $module->is_active == '1' ? 'checked' : '') }} class="custom-control-input" id="active">
									<label class="custom-control-label" for="active">Active</label>
								</div>
								<div class="custom-control custom-radio">
									<input type="radio" name="is_active" value="0" {{ old('is_active', $module->is_active == '0' ? 'checked' : '') }} class="custom-control-input" id="inactive">
									<label class="custom-control-label" for="inactive">Inactive</label>
								</div>
							</div>
							<div class="form-group pt-2 mb-1">
	                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
	                            <a href="{{ route('Modules') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
	                        </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endsection
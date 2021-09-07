@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('settings.nav')
					<div class="card-body">
						<form action="{{ route('Submit Group', ['id' => $id]) }}" method="POST" autocomplete="off">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="name">Name: <strong class="text-danger">*</strong></label>
								<input type="text" name="name" value="{{ old('name', $group->name) }}" class="form-control form-control-sm" required>
							</div>
							<div class="form-group">
								<label for="alias">Alias: <strong class="text-danger">*</strong></label>
								<input type="text" name="alias" value="{{ old('alias', $group->alias) }}" class="form-control form-control-sm" required>
							</div>
							<div class="form-group">
								<div class="text-left"><h5><i>Group Signatories</i></h5></div>
							</div>
							<div class="form-group">
								<label>Reservation:</label>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="recommending" value="0">
									<input type="checkbox" name="recommending" value="1" {{ old('recommending', $group->recommending ? 'checked' : '') }} class="custom-control-input" id="recommending">
									<label class="custom-control-label" for="recommending">Recommending</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="approval" value="0">
									<input type="checkbox" name="approval" value="1" {{ old('approval', $group->approval ? 'checked' : '') }} class="custom-control-input" id="approval">
									<label class="custom-control-label" for="approval">Approval</label>
								</div>
							</div>
							<div class="form-group">
								<label>Travel Order:</label>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="travel_recommending" value="0">
									<input type="checkbox" name="travel_recommending" value="1" {{ old('travel_recommending', $group->travel_recommending ? 'checked' : '') }} class="custom-control-input" id="travel_recommending">
									<label class="custom-control-label" for="travel_recommending">Recommending</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="travel_approval" value="0">
									<input type="checkbox" name="travel_approval" value="1" {{ old('travel_approval', $group->travel_approval ? 'checked' : '') }} class="custom-control-input" id="travel_approval">
									<label class="custom-control-label" for="travel_approval">Approval</label>
								</div>
							</div>
							<div class="form-group">
								<label>Leave:</label>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="hr_approval" value="0">
									<input type="checkbox" name="hr_approval" value="1" {{ old('hr_approval', $group->hr_approval ? 'checked' : '') }} class="custom-control-input" id="hr_approval">
									<label class="custom-control-label" for="hr_approval">Human Resource</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="chief_approval" value="0">
									<input type="checkbox" name="chief_approval" value="1" {{ old('chief_approval', $group->chief_approval ? 'checked' : '') }} class="custom-control-input" id="chief_approval">
									<label class="custom-control-label" for="chief_approval">Chief HR</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="leave_recommending" value="0">
									<input type="checkbox" name="leave_recommending" value="1" {{ old('leave_recommending', $group->leave_recommending ? 'checked' : '') }} class="custom-control-input" id="leave_recommending">
									<label class="custom-control-label" for="leave_recommending">Recommending</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="leave_approval" value="0">
									<input type="checkbox" name="leave_approval" value="1" {{ old('leave_approval', $group->leave_approval ? 'checked' : '') }} class="custom-control-input" id="leave_approval">
									<label class="custom-control-label" for="leave_approval">Approval</label>
								</div>
							</div>
							<div class="form-group">
								<label>Offset</label>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="offset_recommending" value="0">
									<input type="checkbox" name="offset_recommending" value="1" {{ old('offset_recommending', $group->offset_recommending ? 'checked' : '') }} class="custom-control-input" id="offset_recommending">
									<label class="custom-control-label" for="offset_recommending">Recommending</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="offset_approval" value="0">
									<input type="checkbox" name="offset_approval" value="1" {{ old('offset_approval', $group->offset_approval ? 'checked' : '') }} class="custom-control-input" id="offset_approval">
									<label class="custom-control-label" for="offset_approval">Approval</label>
								</div>
							</div>
							<div class="form-group mb-2">
								<label>Overtime:</label>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="overtime_recommending" value="0">
									<input type="checkbox" name="overtime_recommending" value="1" {{ old('overtime_recommending', $group->overtime_recommending ? 'checked' : '') }} class="custom-control-input" id="overtime_recommending">
									<label class="custom-control-label" for="overtime_recommending">Recommending</label>
								</div>
								<div class="custom-control custom-checkbox">
									<input type="hidden" name="overtime_approval" value="0">
									<input type="checkbox" name="overtime_approval" value="1" {{ old('overtime_approval', $group->overtime_approval ? 'checked' : '') }} class="custom-control-input" id="overtime_approval">
									<label class="custom-control-label" for="overtime_approval">Approval</label>
								</div>
							</div>
							<div class="form-group">
								<div class="text-left"><h5><i>Group Settings</i></h5></div>
							</div>
							<div class="form-group mb-1">
								<label>Location:</label>
								<div class="custom-control custom-radio">
									<input type="radio" name="location" value="1" {{ old('location', $group->location == '1' ? 'checked' : '') }} class="custom-control-input" id="regional">
									<label class="custom-control-label" for="regional">Regional Office</label>
								</div>
								<div class="custom-control custom-radio">
									<input type="radio" name="location" value="0" {{ old('location', $group->location == '0' ? 'checked' : '') }} class="custom-control-input" id="provincial">
									<label class="custom-control-label" for="provincial">Provincial Office</label>
								</div>
							</div>
							<div class="form-group mb-1">
								<label>Whereabouts:</label>
								<div class="custom-control custom-radio">
									<input type="radio" name="whereabouts" value="1" {{ old('whereabouts', $group->whereabouts == '1' ? 'checked' : '') }} class="custom-control-input" id="whereabouts_active">
									<label class="custom-control-label" for="whereabouts_active">Active</label>
								</div>
								<div class="custom-control custom-radio">
									<input type="radio" name="whereabouts" value="0" {{ old('whereabouts', $group->whereabouts == '0' ? 'checked' : '') }} class="custom-control-input" id="whereabouts_inactive">
									<label class="custom-control-label" for="whereabouts_inactive">Inactive</label>
								</div>
							</div>
							<div class="form-group">
								<label>Status:</label>
								<div class="custom-control custom-radio">
									<input type="radio" name="is_active" value="1" {{ old('is_active', $group->is_active == '1' ? 'checked' : '') }} class="custom-control-input" id="active">
									<label class="custom-control-label" for="active">Active</label>
								</div>
								<div class="custom-control custom-radio">
									<input type="radio" name="is_active" value="0" {{ old('is_active', $group->is_active == '0' ? 'checked' : '') }} class="custom-control-input" id="inactive">
									<label class="custom-control-label" for="inactive">Inactive</label>
								</div>
							</div>
							<div class="form-group pt-2 mb-1">
	                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
	                            <a href="{{ route('Groups') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
	                        </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endsection
@extends('layouts.content')
	@section('content')
		<div class="card mb-4">
			<h6 class="card-header"><small class="font-weight-bold text-primary">{!! $date->format('F d, Y') !!}</small></h6>
			<div class="card-body">
				<form action="{{ route('Whereabouts') }}" class="form-inline">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
	                        <span class="input-group-text rounded-0"><i class="fa fa-search"></i></span>
	                    </div>
	                    <input type="text" name="search" class="form-control form-control-sm rounded-0 mr-2" placeholder="Search">
					</div>
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
		                    <span class="input-group-text rounded-0">Date</span>
		                </div>
	                	<input type="text" name="date" id="date" value="{{ $input_date }}" class="form-control form-control-sm rounded-0">
	                </div>
	                <input type="Submit" class="btn btn-primary btn-sm rounded-0 ml-2">
				</form>
			</div>
		</div>
		<div class="card-columns">
			@foreach($groups as $group)
				<div class="card mb-4">
					<h6 class="card-header"><small class="text-primary font-weight-bold">{!! $group->name !!}</small></h6>
					<div class="card-body">
						@foreach($group->employees as $employee)
							<div class="row">
								<div class="col-md-3 text-center">
									<div class="whereabouts-frame rounded-circle text-center">
										<img src="{{ $employee->photo() }}" class="comment-image text-center">
									</div>
								</div>
								<div class="col-md-9 d-flex flex-column py-4">
									<div class="d-flex align-items-center">
					                    <small class="font-weight-bold text-muted float-left mx-auto w-100">{!! $employee->full_name !!}</small>
					                    <small class="font-weight-bold text-nowrap">{!! $employee->whereabouts_time_in($date) !!} @if($employee->whereabouts_time_in($date, 1)) - @endif {!! $employee->whereabouts_time_in($date, 1) !!}</small>
					                </div>
					                <div class="d-flex align-items-center">
					                    <small class="font-weight-bold text-muted float-left mx-auto w-100">{!! $employee->designation !!}</small>
					                    <small class="font-weight-bold text-nowrap">
					                    	@if($travels)
						                    	@foreach($travels as $travel)
						                    		@if($travel->travel_passengers->contains($employee->id) || $travel->employee_id == $employee->id)
						                    			<a href='#' class='text-decoration-none' data-toggle='tooltip' data-title='{{ $travel->destination }}'>Official Business</a>
						                    			@break;
						                    		@endif
						                    	@endforeach
						                    @endif
						                    {!! getEmployeeOffset($employee->id, $date, $mode = 1) !!}
						                    {!! getEmployeeLeave($employee->id, $date, 0) !!}
					                    </small>
					                </div>
								</div>
							</div>
							@if(!$loop->last)<hr>@endif
						@endforeach
					</div>
				</div>
			@endforeach
		</div>
	@endsection
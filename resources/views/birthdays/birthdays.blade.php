@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header pt-3 mb-0 pb-0 border-0">
						<h6 class="card-title text-center mb-0 float-left mx-auto w-100"><small class="text-primary font-weight-bold"><i class="fa fa-birthday-cake"></i> Happy Birthday! {{ date('F d, Y') }}</small></h6>
					</div>
					<div class="card-body pt-0 mt-0">
						<hr>
						<div class="row">
							@foreach($bdays as $birthday)
		    					<div class="d-inline-block mx-auto text-center px-2">						
									<img src="{{ $birthday->employee->photo() }}" class="image-responsive rounded-circle mx-auto my-3" width="150" height="150">
									@if($birthday->employee->info)
										<div class="text-center font-weight-bold birthday-rows" data-route="{{ route('Read Birthday', ['id' => $birthday->id]) }}">{!! $birthday->employee->info->gender == 'Male' ? 'Mr.' : 'Ms.' !!} {!! $birthday->employee->full_name !!}</div>
									@endif
		    					</div>
		    				@endforeach
						</div>
						<hr class="mb-2">
			    		<div class="row">
			    			<div class="col-md-12">
			    				<form action="{{ route('Submit Birthday Comment') }}" method="POST" autocomplete="off">
									{{ csrf_field() }}
									<div class="form-group">
			                            <label for="commentBox">Leave a comment</label>
			                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
			                        </div>
			                        <div class="form-group mb-1">
			                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
			                        </div>
			                    </form>
			    			</div>
			    		</div>
	    				<hr>
	    				<div class="row">
			    			@if(count($greetings))
								@foreach($greetings as $greeting)
									<div class="d-block w-100">
										<div class="px-3">
											<img src="{{ $greeting->greeting->photo() }}" class="image-responsive rounded-circle d-inline-block" width="100" height="100">
											<div class="d-inline-block pl-2 align-middle">
												<div><small class="text-primary font-weight-bold">{!! $greeting->greeting->full_name !!}</small></div>
												<div>{!! $greeting->remarks !!}</div>
												<div><small class="text-muted">{!! getDateDiff($greeting->updated_at) !!}</small></div>
											</div>
											@if(!$loop->last)<hr>@endif
										</div>
									</div>
								@endforeach
							@endif
			    		</div>
					</div>
				</div>
			</div>
		</div>

    @endsection
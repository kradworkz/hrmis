<div class="modal fade" id="birthday-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
	    <div class="modal-content rounded-0">
	    	<div class="modal-header pt-3 mb-0 pb-0 border-0">
	    		<h5 class="mb-0 mx-auto font-weight-bold text-center">
	    			<div class="text-center text-primary"><i class="fa fa-birthday-cake"></i> Happy Birthday! {!! date('F d, Y') !!}</div>
	    		</h5>
	    	</div>
	    	<div class="modal-body pt-0 mt-0">
		    	<hr>
	    		<div class="row">
    				@foreach($birthdays as $birthday)
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
	                        	<button class="btn btn-sm btn-block btn-danger rounded-0" data-dismiss="modal">Close</button>
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
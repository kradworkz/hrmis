@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('DTR Override') }}"><small class="text-primary font-weight-bold">Profile</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Comment', ['id' => $id, 'module' => 5]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="date">Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('date') }}</i></label>
							<input type="text" name="date" value="{{ old('date', optional($dtr->time_in)->format('m/d/Y')) }}" id="date" class="form-control form-control-sm" disabled>
						</div>
						<div class="form-group">
					        <label>Time In <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time_in') }}</i></label>
					        <input type="time" id="time_in" name="time_in" value="{{ old('time_in', optional($dtr->time_in)->format('h:i')) }}" class="form-control form-control-sm" disabled>
					    </div>
					    <div class="form-group">
					        <label>Time Out <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time_out') }}</i></label>
					        <input type="time" id="time_out" name="time_out" value="{{ old('time_out', optional($dtr->time_out)->format('h:i')) }}" class="form-control form-control-sm" disabled>
					    </div>
					    <div class="form-group mb-0">
					        <label>Work Location: <span class="text-primary font-weight-bold">{{ $dtr->location == 1 ? 'Office' : 'Home' }}</span></label>
					    </div>
					    <div class="form-group">
					    	<h6>Attachments:
					    		@foreach($dtr->attachments as $attachment)
					    			<div><a class="text-decoration-none" href="{{ route('Get File Attachment', ['filename' => $attachment->filename]) }}" target="_blank">{!! $attachment->title !!}</a></div>
					    		@endforeach
					    	</h6>
					    </div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-body py-3 px-4">
						@include('layouts.comment', ['comments' => $dtr])
					</div>
					<div class="card-footer rounded-0">
						<div class="form-group">
                            <label for="commentBox">Comment</label>
                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Daily Time Record') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
					</form>
				</div>
			</div>
		</div>
	@endsection
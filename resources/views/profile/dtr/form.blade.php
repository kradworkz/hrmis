@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('DTR Override') }}"><small class="text-primary font-weight-bold">Profile</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Daily Time Record', ['id' => $id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="date">Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('date') }}</i></label>
							<input type="date" name="date" value="{{ old('date', $dtr->time_in ? $dtr->time_in->format('Y-m-d') : date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" id="dateTime" class="form-control form-control-sm">
						</div>
						<div class="form-group">
					        <label>Time In <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time_in') }}</i></label>
					        <input type="time" id="time_in" name="time_in" value="{{ old('time_in', optional($dtr->time_in)->format('h:i')) }}" class="form-control form-control-sm" required>
					    </div>
					    <div class="form-group">
					        <label>Time Out <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time_out') }}</i></label>
					        <input type="time" id="time_out" name="time_out" value="{{ old('time_out', optional($dtr->time_out)->format('h:i')) }}" class="form-control form-control-sm" required>
					    </div>
					    <div class="form-group">
					        <div>Work Location</div>
					        <div class="form-check form-check-inline">
					            <input class="form-check-input" type="radio" name="location" id="home" value="0" {{ $dtr->location == 0 ? 'checked' : ''}}>
					            <label class="form-check-label" for="home">Home</label>
					        </div>
					        <div class="form-check form-check-inline">
					            <input class="form-check-input" type="radio" name="location" id="office" value="1" {{ $dtr->location == 1 ? 'checked' : ''}}>
					            <label class="form-check-label" for="office">Office</label>
					        </div>
					    </div>
					    <div class="form-group">
							<label>File Attachment <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('attachments') }}</i></label>
							<input type="file" name="attachments" class="form-control-file">
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
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
		<script>		
			$(document).ready(function() {
				var date = $('#dateTime').val();
				dtrSearch(date);
				$('#dateTime').change(function() {
					var date = $('#dateTime').val();
					dtrSearch(date);
				});

				function dtrSearch(date) {
					$.ajax({ 
						url: "/profile/dtr/search/"+date,
						type: 'GET',
						data: { date: date },
						dataType: 'JSON',
						success: function(data) {
							if(data == 0) {
								$('#time_in, #time_out').val("");
							}
							else {
								$('#time_in').val(data['time_in']);
								$('#time_out').val(data['time_out']);
							}			
						}
					});
				}
			});
		</script>
	@endsection
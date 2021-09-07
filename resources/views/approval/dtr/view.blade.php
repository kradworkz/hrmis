@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('DTR Approval') }}">Daily Time Record</a> <i class="fa fa-angle-double-right fa-xs"></i> {{ Route::currentRouteName() }}</h6>
					<div class="card-body">
						<form action="{{ route('Submit DTR Approval', ['id' => $id]) }}" method="POST" autocomplete="off">
					    {{ csrf_field() }}
					    <div class="form-group mb-0">
					        <label>Created By: <i class="text-primary font-weight-bold">{!! $dtr->employee->full_name !!}</i></label>
					        <input type="hidden" name="employee_id" value="{{ $dtr->employee->id }}">
					    </div>
					    <div class="form-group mb-0">
					    	<label>Date: <i class="text-primary font-weight-bold">{!! $dtr->time_in->format('F d, Y') !!}</i></label>
					        <input type="hidden" name="date" value="{{ $dtr->time_in->format('Y-m-d') }}">
					    </div>
					    <div class="form-group mb-0">
					        <label>Time In: <i class="text-primary font-weight-bold">{!! $dtr->time_in->format('h:i A') !!}</i></label>
					        <input type="hidden" name="time_in" value="{{ $dtr->time_in }}">
					    </div>
					    <div class="form-group mb-0">
					        <label>Time Out: <i class="text-primary font-weight-bold">{!! $dtr->time_out->format('h:i A') !!}</i></label>
					        <input type="hidden" name="time_out" value="{{ $dtr->time_out }}">
					    </div>
					    <div class="form-group mb-0">
				            <label>Work Location: <i class="text-primary font-weight-bold">{!! $dtr->location == 1 ? 'Office' : 'Home' !!}</i></label>
				            <input type="hidden" name="location" value="{{ $dtr->location }}">
				        </div>
					    <div class="form-group mb-0">
					        <label>File Attachments:
					            @foreach($dtr->attachments as $attachment)
					                <div><a class="text-decoration-none" href="{{ route('Get File Attachment', ['filename' => $attachment->filename]) }}" target="_blank"><i class="font-weight-bold">{!! $attachment->title !!}</i></a></div>
					            @endforeach
					        </label>
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
					        <h6><i class="text-info">Action:</i> </h6>
					        <div class="custom-control custom-radio custom-control-inline">
					            <input type="radio" name="status" value="0" {{ old('status', $dtr->status == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
					            <label class="custom-control-label" for="pending">Pending</label>
					        </div>
					        <div class="custom-control custom-radio custom-control-inline">
					            <input type="radio" name="status" value="1" {{ old('status', $dtr->status == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
					            <label class="custom-control-label" for="approved">Approved</label>
					        </div>
					        <div class="custom-control custom-radio custom-control-inline">
					            <input type="radio" name="status" value="2" {{ old('status', $dtr->status == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
					            <label class="custom-control-label" for="disapproved">Disapproved</label>
					        </div>
					    </div>
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
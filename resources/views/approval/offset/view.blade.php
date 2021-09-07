@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Offset Approval') }}"><small class="text-primary font-weight-bold">Offset</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Offset Approval', ['id' => $id]) }}" method="POST" autocomplete="off">
					    {{ csrf_field() }}
					    <div class="form-group mb-0">
					        <label>Created By: <i class="text-primary font-weight-bold">{!! $offset->employee->full_name !!}</i></label>
					    </div>
					    <div class="form-group mb-0">
					    	<label>Date: <i class="text-primary font-weight-bold">{!! $offset->date->format('F d, Y') !!}</i></label>
					    </div>
					    <div class="form-group mb-0">
					    	<label>Time: <i class="text-primary font-weight-bold">{!! $offset->time !!}</i></label>
					    </div>
					    <div class="form-group mb-0">
					    	<label>Hours: <i class="text-primary font-weight-bold">{!! $offset->hours !!}</i></label>
					    </div>
					    <div class="form-group mb-0">
					    	<label>Remarks: <i class="text-primary font-weight-bold">{!! $offset->remarks !!}</i></label>
					    </div>
					    <div class="form-group mb-0">
					    	<label>Covid Positive: <i class="text-primary font-weight-bold">{!! $offset->is_positive == 1 ? 'Yes' : 'No' !!}</i></label>
					    </div>
					    @if($offset->is_positive == 1 && $offset->attachment)
					    <div class="form-group">
					    	<label>Attachment: <a class="text-decoration-none" href="{{ route('Get File Attachment', ['filename' => $offset->attachment->filename]) }}" target="_blank"><i class="font-weight-bold">{!! $offset->attachment->title !!}</i></a></label>
					    </div>
					    @endif
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-body py-3 px-4">
						@include('layouts.comment', ['comments' => $offset])
					</div>
					<div class="card-footer rounded-0">
						@if(count($approvals))
					    <table class="table table-sm table-condensed table-borderless table-hover">
					        <tbody>
					            @foreach($approvals as $approval)
					                <tr>
					                    <td><i>{!! $approval->employee->full_name !!}</i></td>
					                    <td>
					                        @if($approval->action == 0)
					                            <i class="text-warning font-weight-bold">PENDING</i>
					                        @elseif($approval->action == 1)
					                            <i class="text-success font-weight-bold">APPROVED</i>
					                        @elseif($approval->action == 2)
					                            <i class="text-danger font-weight-bold">DISAPPROVED</i>
					                        @endif
					                    </td>
					                    <td class="text-right">{!! $approval->created_at->format('F d, Y h:i A') !!}</td>
					                </tr>
					            @endforeach
					        </tbody>
					    </table>
					    @endif
						@include('layouts.signatory', ['signatory' => 'offset_signatory', 'module' => $offset])
						<div class="form-group">
                            <label for="commentBox">Comment</label>
                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Offset') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
					</form>
				</div>
			</div>
		</div>
	@endsection
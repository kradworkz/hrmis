@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Overtime Approval') }}"><small class="text-primary font-weight-bold">Overtime Request</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Overtime Approval', ['id' => $id]) }}" method="POST" autocomplete="off">
					    {{ csrf_field() }}
						<div class="form-group mb-0">
					        <label>Created By: <i class="text-primary font-weight-bold">{!! $overtime->employee->full_name !!}</i></label>
					    </div>
					    <div class="form-group mb-0">
					    	<label>Date: <i class="text-primary font-weight-bold">{!! $overtime->overtime_dates !!}</i></label>
					    </div>
					    <div class="form-group mb-0">
					    	<label>Employees: 
					    		@foreach($overtime->overtime_personnel as $passenger)
					    			<span class="badge badge-primary">{!! $passenger->full_name !!}</span>
					    		@endforeach
					    	</label>
					    </div>
					    <div class="form-group mb-0">
					    	<label>Purpose: <div><i class="text-primary font-weight-bold">{!! nl2br($overtime->purpose) !!}</i></div></label>
					    </div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-body py-3 px-4">
						@include('layouts.comment', ['comments' => $overtime])
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
					    @include('layouts.signatory', ['signatory' => 'overtime_signatory', 'module' => $overtime])
						<div class="form-group">
                            <label for="commentBox">Comment</label>
                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Overtime Approval') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
				</div>
				</form>
			</div>
		</div>
	@endsection
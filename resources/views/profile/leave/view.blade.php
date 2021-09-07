@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Leave') }}"><small class="text-primary font-weight-bold">Profile</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Comment', ['id' => $id, 'module' => 6]) }}" method="POST" autocomplete="off">
						{{ csrf_field() }}
							<div class="form-group">
						        <h6>Created By: <div><i class="text-primary">{!! $leave->employee->full_name !!}</i></div></h6>
						    </div>
						    <div class="form-group">
						    	<h6>Date: <div><i class="text-primary">{!! $leave->off_dates !!}</i></div></h6>
						    </div>
						    @if($leave->type == 'Vacation Leave')
							    <div class="form-group">
							    	<h6>Type of Leave: <div><i class="text-primary">{!! $leave->vacation_leave == 'Others' ? $leave->vacation_leave_specify : $leave->vacation_leave !!}</i></div></h6>
							    </div>
							    <div class="form-group">
							    	<h6>Location: <div><i class="text-primary">{!! $leave->vacation_location !!}</i></div></h6>
							    </div>
							    <div class="form-group">
							    	<h6>Where: <div><i class="text-primary">{!! $leave->vacation_location_specify !!}</i></div></h6>
							    </div>
						    @else
						    	<div class="form-group">
							    	<h6>Type of Leave: <div><i class="text-primary">{!! $leave->sick_leave == 'Others' ? $leave->sick_leave_specify : $leave->sick_leave !!}</i></div></h6>
							    </div>
							    <div class="form-group">
							    	<h6>Location: <div><i class="text-primary">{!! $leave->sick_location !!}</i></div></h6>
							    </div>
							    <div class="form-group">
							    	<h6>Where: <div><i class="text-primary">{!! $leave->sick_location_specify !!}</i></div></h6>
							    </div>
						    @endif
						    <div class="form-group">
						    	<h6>Commutation: <div><i class="text-primary">{!! $leave->commutation !!}</i></div></h6>
						    </div>
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
						    @if(count($disapproved_dates))
						    <table class="table table-sm table-condensed table-borderless table-hover">
						    	<thead>
						    		<tr>
						    			<th>Disapproved Date(s)</th>
						    			<th class="text-center">Chief Administrative Officer/HRMO</th>
						    			<th class="text-center">Immediate Supervisor</th>
						    			<th class="text-center">Regional Director</th>
						    		</tr>
						    	</thead>
						        <tbody>
						            @foreach($disapproved_dates as $cancelled)
						                <tr>
						                    <td><i>{!! $cancelled->date->format('F d, Y') !!}</i></td>
						                    <td class="text-center">@if($cancelled->chief_approval == 2)<i class="fa fa-times text-danger" data-toggle="tooltip" data-title="Disapproved"></i>@elseif($cancelled->chief_approval == 1)<i class="fa fa-check text-success" data-toggle="tooltip" data-title="Approved"></i>@else<i class="fa fa-exclamation text-warning" data-toggle="tooltip" data-title="Pending"></i>@endif</td>
						                    <td class="text-center">@if($cancelled->recommending == 2)<i class="fa fa-times text-danger" data-toggle="tooltip" data-title="Disapproved"></i>@elseif($cancelled->recommending == 1)<i class="fa fa-check text-success" data-toggle="tooltip" data-title="Approved"></i>@else<i class="fa fa-exclamation text-warning" data-toggle="tooltip" data-title="Pending"></i>@endif</td>
						                    <td class="text-center">@if($cancelled->approval == 2)<i class="fa fa-times text-danger" data-toggle="tooltip" data-title="Disapproved"></i>@elseif($cancelled->approval == 1)<i class="fa fa-check text-success" data-toggle="tooltip" data-title="Approved"></i>@else<i class="fa fa-exclamation text-warning" data-toggle="tooltip" data-title="Pending"></i>@endif</td>
						                </tr>
						            @endforeach
						        </tbody>
						    </table>
						    @endif
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-body py-3 px-4">
						@include('layouts.comment', ['comments' => $leave])
					</div>
					<div class="card-footer rounded-0">
						<div class="form-group">
                            <label for="commentBox">Comment</label>
                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Leave') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
					</form>
				</div>
			</div>
		</div>
	@endsection
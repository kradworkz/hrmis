@if(count($approvals->approval_status))
	@foreach($approvals->approval_status as $approval)
		<div>{!! $approval->employee->full_initials !!}: {!! $approval->action == 0 ? '<i class="fa fa-exclamation-circle text-warning" data-toggle="tooltip" data-title="Pending"></i>' : ($approval->action == 1 ? '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-title="Approved"></i>' : '<i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-title="Disapproved"></i>') !!} {!! $approval->created_at->format('F d, Y h:i A') !!}</div>
	@endforeach
@else
	@if($approvals->is_active == 1) {!! getStatus($approvals) !!} @else <i><small class="font-weight-bold text-danger">CANCELLED</small></i> @endif
@endif
<div class="card-body p-0">
	@if(count(Auth::user()->notifications_all))
		<table class="table mb-0 table-borderless table-hover">
		@foreach(Auth::user()->notifications_all as $notification)
			<tr>
				<td>
					@if($notification->action == 'Comment')
						<strong>{!! $notification->employee->full_name !!}</strong> 
						@if($notification->reference->employee_id == Auth::id())
						commented on your <strong class="text-primary">{!! $notification->type !!}</strong>.
						@else
						commented on a <strong class="text-primary">{!! $notification->type !!}</strong> that you're tagged in.
						@endif
					@elseif($notification->action == 'Tag')
						<strong>{!! $notification->employee->full_name !!}</strong> tagged you in a <strong class="text-primary">{!! $notification->type !!}</strong>.
					@elseif($notification->action == 'Approved' || $notification->action == 'Disapproved')
						<strong>{!! $notification->employee->full_name !!}</strong> {{ strtolower($notification->action) }} your <strong class="text-primary">{!! $notification->type !!}</strong>.
					@endif
				</td>
				<td class="text-right"><small class="text-muted">{!! $notification->created_at->diffForHumans() !!}</small></td>
			</tr>
		@endforeach
		</table>
	@endif
</div>
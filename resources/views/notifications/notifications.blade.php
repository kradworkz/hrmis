<div id="notification-content" hidden>
	@if(count(Auth::user()->notifications))
		<div class="card">
			@foreach(Auth::user()->notifications as $notification)
				@if($notification->reference)
					<a href="{{ route($notification->parameters, ['id' => $notification->reference_id]) }}" class="text-decoration-none text-dark">
						<div class="card-body p-2 notification-item text-decoration-none">
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
							<small class="text-muted">{!! $notification->created_at->diffForHumans() !!}</small>
						</div>
					</a>
				@endif
			@endforeach
		</div>
		@if(count(Auth::user()->notifications) > 10)
		<a href="" class="text-center">
			<div class="card-footer bg-white p-2 px-3">See All</div>
		</a>
		@endif
	@endif
	@if(!Auth::user()->info)
		<div class="card">
			<a href="{{ route('Personal Information', ['id' => Auth::id()]) }}" class="text-decoration-none text-dark">
				<div class="card-body p-2 notification-item text-decoration-none">
					<strong>Reminder: </strong> Advisory from HR. Please update your <span class="text-primary font-weight-bold">Personal Data Sheet</span>. You can click this notification to redirect to the page. Thank you.
				</div>
			</a>
		</div>
	@elseif(!Auth::user()->family)
		<div class="card">
			<a href="{{ route('Family Background', ['id' => Auth::id()]) }}" class="text-decoration-none text-dark">
				<div class="card-body p-2 notification-item text-decoration-none">
					<strong>Reminder: </strong> Advisory from HR. Please update your <span class="text-primary font-weight-bold">Family Background</span>. You can click this notification to redirect to the page. Thank you.
				</div>
			</a>
		</div>
	@elseif(!Auth::user()->education)
		<div class="card">
			<a href="{{ route('Educational Background', ['id' => Auth::id()]) }}" class="text-decoration-none text-dark">
				<div class="card-body p-2 notification-item text-decoration-none">
					<strong>Reminder: </strong> Advisory from HR. Please update your <span class="text-primary font-weight-bold">Educational Background</span>. You can click this notification to redirect to the page. Thank you.
				</div>
			</a>
		</div>
	@endif
	@if(count(Auth::user()->missing_timeout()))
		<div class="card">
			<a href="{{ route('New Daily Time Record') }}" class="text-decoration-none text-dark">
				<div class="card-body p-2 notification-item text-decoration-none">
					<strong>Reminder: </strong> 
					You have missing <span class="text-danger font-weight-bold">TIME OUT</span> for the date(s)
					@foreach(Auth::user()->missing_timeout() as $date) 
						<span class="text-info font-weight-bold">{!! $date->time_in->format('F d') !!}</span>@if(!$loop->last), @else.@endif
					@endforeach
					You can click this notification to redirect to the page. Thank you.
				</div>
			</a>
		</div>
	@endif
	@if(Auth::user()->quarantine != NULL && Auth::user()->quarantine->approval == 1)
		@if(Auth::user()->quarantine->recommendation = '7 days quarantine' || Auth::user()->quarantine->recommendation = '14 days quarantine')
			<div class="card">
				<a href="{{ route('View Home Quarantine', ['id' => Auth::user()->quarantine->id]) }}" class="text-decoration-none text-dark">
					<div class="card-body p-2 notification-item text-decoration-none">
						<strong>Reminder:</strong>
						You have been recommended to work from home starting <span class="text-primary font-weight-bold">{!! Auth::user()->quarantine->quarantine_dates !!}.</span> 
						@if(Auth::user()->quarantine->medical_certificate == 1) You are required to submit medical certificate after your quarantine. @endif
					</div>
				</a>
			</div>
		@endif
	@endif
</div>
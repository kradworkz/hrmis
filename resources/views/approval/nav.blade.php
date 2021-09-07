<div class="card-header">
	<div class="d-flex align-items-center">
		<ul class="nav nav-tabs card-header-tabs float-left mx-auto w-100">
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('approval/list') || Request::is('approval/list/*') ? 'active' : '' }}" href="{{ route('Approval', ['module_id' => 1]) }}">Signatories</a>
			</li>
			@if(Auth::user()->is_superuser() || Auth::user()->is_hr())
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('approval/dtr') || Request::is('approval/dtr/*') ? 'active' : '' }}" href="{{ route('DTR Approval') }}">Daily Time Record @if($pending_attendance != 0)<span class="approval-badge bg-danger">{{ $pending_attendance }}</span>@endif</a>
			</li>
			@endif
			@if(Auth::user()->reservation_signatory || Auth::user()->is_superuser() || Auth::user()->is_assistant() || Auth::user()->is_health_officer())
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('approval/vehicles') || Request::is('approval/vehicles/*') ? 'active' : '' }}" href="{{ route('Vehicle Approval') }}">Vehicle Reservation @if($pending_reservations != 0)<span class="approval-badge bg-danger">{{ $pending_reservations }}</span>@endif</a>
			</li>
			@endif
			@if(Auth::user()->travel_signatory || Auth::user()->is_superuser())
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('approval/travels') || Request::is('approval/travels/*') ? 'active' : '' }}" href="{{ route('Travel Approval') }}">Travel Order @if($pending_travels != 0)<span class="approval-badge bg-danger">{{ $pending_travels }}</span>@endif</a>
			</li>
			@endif
			@if(Auth::user()->leave_signatory || Auth::user()->is_superuser())
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('approval/leave') || Request::is('approval/leave/*') ? 'active' : '' }}" href="{{ Route('Leave Approval') }}">Leave @if($pending_leave != 0)<span class="approval-badge bg-danger">{{ $pending_leave }}</span>@endif</a>
			</li>
			@endif
			@if(Auth::user()->offset_signatory || Auth::user()->is_superuser())
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('approval/offset') || Request::is('approval/offset/*') ? 'active' : '' }}" href="{{ route('Offset Approval') }}">Offset @if($pending_offset != 0)<span class="approval-badge bg-danger">{{ $pending_offset }}</span>@endif</a>
			</li>
			@endif
			@if(Auth::user()->overtime_signatory || Auth::user()->is_superuser())
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('approval/overtime') || Request::is('approval/overtime/*') ? 'active' : '' }}" href="{{ route('Overtime Approval') }}">Overtime Request @if($pending_overtime != 0)<span class="approval-badge bg-danger">{{ $pending_overtime }}</span>@endif</a>
			</li>
			@endif
			@if(Auth::user()->is_health_officer() || Auth::user()->is_superuser())
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('approval/health') || Request::is('approval/health/*') ? 'active' : '' }}" href="{{ route('Health Check Approval') }}">Health Check</a>
			</li>
			@endif
			@if(Auth::user()->health_signatory || Auth::user()->is_superuser() || Auth::user()->is_health_officer() || Auth::user()->is_hr())
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('approval/quarantine') || Request::is('approval/quarantine/*') ? 'active' : '' }}" href="{{ route('Employee Quarantine Approval') }}">Employee Quarantine @if($employee_quarantine != 0)<span class="approval-badge bg-danger">{{ $employee_quarantine }}</span>@endif</a>
			</li>
			@endif
		</ul>
		@if(Auth::user()->is_hr() && Request::is('approval/dtr'))
		<a href="#" class="badge badge-primary rounded-0" id="newDTR" data-toggle="modal" data-target="#approvalModal" data-url="{{ route('New DTR') }}" data-view="">NEW</a>
		@elseif(Auth::user()->is_assistant() && Request::is('approval/vehicles'))
		<a href="#" class="badge badge-primary rounded-0" id="newDTR" data-toggle="modal" data-target="#approvalModal" data-url="{{ route('New Vehicle Reservation') }}" data-view="">NEW</a>
		@endif
	</div>
</div>
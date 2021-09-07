<div class="card-header font-weight-normal text-muted">
	<div class="d-flex align-items-center">
		@if(Auth::user()->is_hr())
			<h6 class="card-title mb-0 float-left mx-auto w-100"><a class="text-decoration-none" href="{{ route('Employees') }}"><small class="font-weight-bold text-primary">Employees</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <a href="{{ route('View Employee Profile', ['id' => isset($employee) ? $employee->id : \Auth::id()]) }}" class="text-decoration-none"><small class="font-weight-bold text-primary">{!! isset($employee) ? $employee->full_name : \Auth::user()->full_name !!}</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="font-weight-bold text-muted">201 File</small></h6>
			<a href="{{ route('Get PDS', ['filename' => $employee->username]) }}" target="_blank" class="badge badge-primary rounded-0" data-toggle="tooltip" data-title="Download PDS"><i class="fa fa-print"></i></a>
		@else
			<h6 class="card-title mb-0 float-left mx-auto w-100"><a class="text-decoration-none" href="{{ route('Profile') }}"><small class="text-primary font-weight-bold">Profile</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">201 File</small></h6>
			<a href="{{ route('Get PDS', ['filename' => Auth::user()->username]) }}" target="_blank" class="badge badge-primary rounded-0" data-toggle="tooltip" data-title="Download PDS"><i class="fa fa-print"></i></a>
		@endif
	</div>
</div>
<div class="card-header">
	<div class="d-flex align-items-center">
		<ul class="nav nav-tabs card-header-tabs float-left mx-auto w-100">
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/pds/info/'.Request::segment(4)) || Request::is('employees/pds/info/'.Request::segment(4).'/*') ? 'active' : '' }}" href="{{ route('Personal Information', ['id' => isset($employee) ? $employee->id : \Auth::id()]) }}">Personal Information</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/pds/family/'.Request::segment(4)) || Request::is('employees/pds/family/'.Request::segment(4).'/*') ? 'active' : '' }}" href="{{ route('Family Background', ['id' => isset($employee) ? $employee->id : \Auth::id()]) }}">Family Background</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/pds/education/'.Request::segment(4)) || Request::is('employees/pds/education/'.Request::segment(4).'/*') ? 'active' : '' }}" href="{{ route('Educational Background', ['id' => isset($employee) ? $employee->id : \Auth::id()]) }}">Educational Background</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/pds/eligibility/'.Request::segment(4)) || Request::is('employees/pds/eligibility/'.Request::segment(4).'/*') ? 'active' : '' }}" href="{{ route('Civil Service Eligibility', ['id' => isset($employee) ? $employee->id : \Auth::id()]) }}">Civil Service Eligibility</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/pds/experience/'.Request::segment(4)) || Request::is('employees/pds/experience/'.Request::segment(4).'/*') ? 'active' : '' }}" href="{{ route('Work Experience', ['id' => isset($employee) ? $employee->id : \Auth::id()]) }}">Work Experience</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/pds/voluntary/'.Request::segment(4)) || Request::is('employees/pds/voluntary/'.Request::segment(4).'/*') ? 'active' : '' }}" href="{{ route('Voluntary Work', ['id' => isset($employee) ? $employee->id : \Auth::id()]) }}">Voluntary Work</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/pds/training/'.Request::segment(4)) || Request::is('employees/pds/training/'.Request::segment(4).'/*') ? 'active' : '' }}" href="{{ route('Training', ['id' => isset($employee) ? $employee->id : \Auth::id()]) }}">Training</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/pds/other/'.Request::segment(4)) || Request::is('employees/pds/other/'.Request::segment(4).'/*') ? 'active' : '' }}" href="{{ route('Other Information', ['id' => isset($employee) ? $employee->id : \Auth::id()]) }}">Other Information</a>
			</li>
		</ul>
	</div>
</div>
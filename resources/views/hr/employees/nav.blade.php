<div class="card-header font-weight-normal text-muted">
	<div class="d-flex align-items-center">
		<h6 class="card-title mb-0 float-left mx-auto w-100"><a class="text-decoration-none" href="{{ route('Employees') }}"><small class="text-primary font-weight-bold">Employees</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="font-weight-bold text-muted">{!! $employee->full_name !!}</small></h6>
	</div>
</div>
<div class="card-header">
	<div class="d-flex align-items-center">
		<ul class="nav nav-tabs card-header-tabs float-left mx-auto w-100">
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/profile/'.Request::segment(3)) || Request::is('employees/profile/'.Request::segment(3).'/*') ? 'active' : '' }}" href="{{ route('View Employee Profile', ['id' => $id]) }}">Profile</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/attendance/'.Request::segment(3)) || Request::is('employees/attendance/'.Request::segment(3).'/*') ? 'active' : '' }}" href="{{ route('View Employee Attendance', ['id' => $id]) }}">Daily Time Record</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/credits/'.Request::segment(3)) || Request::is('employees/credits/'.Request::segment(3).'/*') ? 'active' : '' }}" href="{{ route('Employee Leave Credit', ['id' => $id]) }}">Leave Credits</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/schedule/'.Request::segment(3)) || Request::is('employees/schedule/'.Request::segment(3).'/*') ? 'active' : '' }}" href="{{ route('View Employee Schedule', ['id' => $id]) }}">Schedule</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees/pds/info/'.Request::segment(4)) || Request::is('employees/pds/info/'.Request::segment(4).'/*') ? 'active' : '' }}" target="_blank" href="{{ route('Personal Information', ['id' => $id]) }}">201 File</a>
			</li>
		</ul>
		<a href="#" class="badge badge-primary rounded-0" data-toggle="modal" data-target="#hrModal">NEW</a>
	</div>
</div>
<div class="modal fade" id="hrModal" tabindex="-1" role="dialog" aria-labelledby="hrModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
        	<div class="modal-body p-1">
	            <div class="list-group">
	            	<a href="#" class="list-group-item list-group-item-action rounded-0" id="newAttendance" data-toggle="modal" data-target="#formModal" data-url="{{ route('New Employee Attendance', ['employee_id' => $employee->id]) }}">Daily Time Record</a>
	            	<a href="#" class="list-group-item list-group-item-action rounded-0" id="newSchedule" data-toggle="modal" data-target="#formModal" data-url="{{ route('New Employee Schedule', ['employee_id' => $employee->id]) }}">Employee Schedule</a>
	            	<a href="#" class="list-group-item list-group-item-action rounded-0" id="newCOC" data-toggle="modal" data-target="#formModal" data-url="{{ route('New Employee COC', ['employee_id' => $employee->id]) }}">Employee COC</a>
	            	<a href="#" class="list-group-item list-group-item-action rounded-0" id="newCredit" data-toggle="modal" data-target="#formModal" data-url="{{ route('New Employee Leave Credit', ['employee_id' => $employee->id]) }}">Leave Credit</a>
				</div>
        	</div>
        </div>
    </div>
</div>
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-0">
            <div class="modal-body">
                <div id="formContainer"></div>
            </div>
        </div>
    </div>
</div>
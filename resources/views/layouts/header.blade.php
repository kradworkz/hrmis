<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<title>{!! Route::currentRouteName() !!}</title>
	<link rel="icon" href="{{ asset('icon/hrmis.svg') }}" type="image/png"/>
	@if(App::environment('local'))
		<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	@else
		<link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
	@endif
	<link rel="stylesheet" type="text/css" href="{{ asset('tools/fontawesome/css/all.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('tools/jquery-datepicker/jquery-ui.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('tools/chosen/chosen.min.css') }}">

	@if(App::environment('local'))
		<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
	@else
		<script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
	@endif
	<script type="text/javascript" src="{{ asset('tools/jquery-datepicker/jquery-ui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('tools/chosen/chosen.jquery.min.js') }}"></script>
</head>
	<nav class="navbar navbar-expand-xl text-white navbar-dark sticky p-0 hrmis-header">
		<div class="container-fluid">
			<a href="{{ route('Daily Time Record') }}" class="navbar-brand">
				<img src="{{ asset('icon/hrmis.svg') }}" width="25" height="25" class="d-inline-block" alt="HRMIS LOGO">
			</a>
			<button class="navbar-toggler border border mr-3" type="button" data-toggle="collapse" data-target="#hrmis-navbar" aria-controls="hrmis-navbar" aria-expanded="false" aria-label="Toggle navigation">
	            <span class="fa fa-bars text-white"></span>
	        </button>
		    <div class="collapse navbar-collapse text-white" id="hrmis-navbar">
	            <ul class="navbar-nav mr-auto">
	            	<li class="nav-item">
                    	<a href="{{ route('Dashboard') }}" class="nav-link font-weight-bold px-3 {{ Request::is('dashboard') || Request::is('dashboard/*') ? 'active' : '' }}">Dashboard</a>
	                </li>
	                <li class="nav-item">
                    	<a href="{{ route('Whereabouts') }}" class="nav-link font-weight-bold px-3 {{ Request::is('whereabouts') || Request::is('whereabouts/*') ? 'active' : '' }}">Whereabouts</a>
	                </li>
	                <li class="nav-item">
                    	<a href="{{ route('Vehicle Calendar') }}" class="nav-link font-weight-bold px-3 {{ Request::is('calendar') || Request::is('calendar/*') ? 'active' : '' }}">Calendar</a>
	                </li>
	                @if(Auth::user()->is_superuser() || Auth::user()->is_hr())
	                <li class="nav-item">
                    	<a href="{{ route('Employees') }}" class="nav-link font-weight-bold px-3 {{ Request::is('employees') || Request::is('employees/*') || Request::is('coc') || Request::is('coc/*') ? 'active' : '' }}">Human Resource</a>
	                </li>
	                <li class="nav-item">
                    	<a href="{{ route('Employee DTR') }}" class="nav-link font-weight-bold px-3 {{ Request::is('dtr') ? 'active' : '' }}">Daily Time Record</a>
	                </li>
	                @endif
	                @if(Auth::user()->is_superuser() || Auth::user()->is_administrator())
		                <li class="nav-item">
	                    	<a href="{{ route('Approval Report') }}" class="nav-link font-weight-bold px-3 {{ Request::is('report') || Request::is('report/*') ? 'active' : '' }}">Graphs</a>
		                </li>
	                @endif
	               	@if(Auth::user()->is_superuser())
	               	<li class="nav-item">
	                	<a href="{{ route('Approval', ['module_id' => 1]) }}" class="nav-link font-weight-bold px-3 {{ Request::is('approval') || Request::is('approval/*') ? 'active' : '' }}">Approval</a>
	                </li>
	               	@elseif(Auth::user()->is_assistant() || Auth::user()->is_health_officer() || count(Auth::user()->signatories) || Auth::user()->is_superuser())
	                <li class="nav-item">
	                	<a href="{{ route('Approval', ['module_id' => 1]) }}" class="nav-link font-weight-bold px-3 {{ Request::is('approval') || Request::is('approval/*') ? 'active' : '' }}">Approval @if($total_approvals != 0)<span class="approval-badge bg-danger">{{ $total_approvals }}</span>@endif</a>
	                </li>
	                @endif
	                @if(count($bday_count))
	                <li class="nav-item">
	                	<a href="{{ route('Birthdays') }}" class="nav-link font-weight-bold px-3 {{ Request::is('birthdays') || Request::is('birthdays/*') ? 'active' : '' }}">Birthdays @if(count($bday_count) != 0)<span class="approval-badge bg-danger">{{ count($bday_count) }}@endif</span></a>
	                </li>
	                @endif
	                @if(Auth::user()->is_superuser() || Auth::user()->is_administrator())
	                <li class="nav-item">
	                	<a href="{{ route('Records List') }}" class="nav-link font-weight-bold px-3 {{ Request::is('records') || Request::is('records/*') ? 'active' : '' }}">Records</a>
	                </li>
	                @endif
	            </ul>
	            <ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link px-3" id="notifications" href="#" title="Notifications">
							<div class="icon-wrapper">
	                			<i class="fa fa-bell"></i>
	                			@php 
	                				$notifications = count(Auth::user()->notifications); 
	                				if(!Auth::user()->info || !Auth::user()->family || !Auth::user()->education) {
	                					$notifications+=1;
	                				}
	                				if(Auth::user()->quarantine != NULL) {
	                					$notifications+=1;
	                				}
	                				if(count(Auth::user()->missing_timeout())) {
	                					$notifications+=1;
	                				}
	                			@endphp
	                			@if($notifications > 0)
	                				<span class="badge badge-danger badge-notification" id="notification-count">{!! $notifications !!}</span>
	                			@endif
	                		</div>
						</a>
						@include('notifications.notifications')
					</li>
					@if(Auth::user()->is_superuser())
	                <li class="nav-item">
                    	<a href="{{ route('Logs') }}" class="nav-link font-weight-bold px-3 {{ Request::is('settings') || Request::is('settings/*') ? 'active' : '' }}">Administrator</a>
	                </li>
	                @endif
	            	<li>
	                	<a href="{{ route('Profile') }}" class="nav-link font-weight-bold px-3 {{ Request::is('profile') || Request::is('profile/*') ? 'active' : '' }}">{{ Auth::user()->full_name }}</a>
	                </li>
	                <li>
	                	<a href="{{ route('logout') }}" data-toggle="tooltip" data-title="Logout" class="nav-link font-weight-bold px-3"><i class="fa fa-sign-out-alt"></i></a>
	                </li>
	            </ul>
	        </div>
		</div>
	</nav>
<body>

@if(count($birthdays))
	@include('layouts.birthday')
@endif

<div class="pds-toast mt-3 ml-3">
	@if(Session::has('message'))
	<div class="toast" role="alert" data-autohide="true" data-delay="1500" aria-live="assertive" aria-atomic="true">
		<div class="toast-header">
			<strong class="mr-auto text-info">Notification</strong>
			<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
	        	<span aria-hidden="true">&times;</span>
	        </button>
		</div>
		<div class="toast-body">
			<span class="font-weight-bold">{!! Session::get('message') !!}</span>
		</div>
	</div>
	@endif
	@if(!Auth::user()->info)
		<div class="toast" role="alert" data-autohide="false" aria-live="assertive" aria-atomic="true">
			<div class="toast-header">
				<strong class="mr-auto text-danger">Reminder</strong>
				<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
		        	<span aria-hidden="true">&times;</span>
		        </button>
			</div>
			<div class="toast-body">
				<span class="font-weight-bold">
					Advisory from HR. Please update your Personal Data Sheet. You can <a href="{{ route('Personal Information', ['id' => Auth::id()]) }}" target="_blank">click here</a> to redirect to the page. Thank you.
				</span>
			</div>
		</div>
	@endif
	@if(count(Auth::user()->missing_timeout()))
	<div class="toast" role="alert" data-autohide="false" aria-live="assertive" aria-atomic="true">
		<div class="toast-header">
			<strong class="mr-auto text-danger">Reminder</strong>
			<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
	        	<span aria-hidden="true">&times;</span>
	        </button>
		</div>
		<div class="toast-body">
			<span class="font-weight-bold">
				You have missing <span class="text-danger">TIME OUT</span> for the date(s)<br>
				@foreach(Auth::user()->missing_timeout() as $date) 
					<span class="text-info">{!! $date->time_in->format('F d') !!}</span>@if(!$loop->last), @else.@endif
				@endforeach
				<a href="{{ route('New Daily Time Record') }}">Click here</a> to request for DTR Override.
			</span>
		</div>
	</div>
	@endif
</div>

<div class="container-fluid {{ Request::is('dashboard') || Request::is('profile/*') ? 'pt-2' : 'pt-4' }} px-4">
	@if(!Request::is('approval/*') && !Request::is('approval'))
	<a href="#" id="floatingBtn" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus myfloat"></i></a>
	
	<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
	        <div class="modal-content">
	        	<div class="modal-body p-0">
		            <div class="list-group">
						<a href="{{ route('New Reservation') }}" class="list-group-item list-group-item-action"><small class="text-primary font-weight-bold">Vehicle Reservation</small></a>
						<a href="{{ route('New Overtime Request') }}" class="list-group-item list-group-item-action"><small class="text-primary font-weight-bold">Overtime Request</small></a>
		            	<a href="{{ route('New Daily Time Record') }}" class="list-group-item list-group-item-action"><small class="text-primary font-weight-bold">DTR Override</small></a>
						<a href="{{ route('New Travel') }}" class="list-group-item list-group-item-action"><small class="text-primary font-weight-bold">Travel Order</small></a>
						<a href="{{ route('New Leave') }}" class="list-group-item list-group-item-action"><small class="text-primary font-weight-bold">Leave</small></a>
						<a href="{{ route('New Offset') }}" class="list-group-item list-group-item-action"><small class="text-primary font-weight-bold">Offset</small></a>
						@if(Auth::user()->is_superuser() || Auth::user()->is_hr())
							<a href="{{ route('New Employee') }}" class="list-group-item list-group-item-action"><small class="text-primary font-weight-bold"> Employee <i class="fa fa-user-shield fa-fw fa-sm" data-toggle="tooltip" data-title="Administrator"></i></small></a>
						@endif
		            	@if(Auth::user()->is_superuser())
		            		<a href="{{ route('New Group') }}" class="list-group-item list-group-item-action"><small class="text-primary font-weight-bold"> Group <i class="fa fa-user-shield fa-fw fa-sm" data-toggle="tooltip" data-title="Administrator"></i></small></a>
			            	<a href="{{ route('New Vehicle') }}" class="list-group-item list-group-item-action"><small class="text-primary font-weight-bold"> Vehicle <i class="fa fa-user-shield fa-fw fa-sm" data-toggle="tooltip" data-title="Administrator"></i></small></a>
			            	<a href="{{ route('New Signatory') }}" class="list-group-item list-group-item-action"><small class="text-primary font-weight-bold"> Signatory <i class="fa fa-user-shield fa-fw fa-sm" data-toggle="tooltip" data-title="Administrator"></i></small></a>
		            	@endif
					</div>
	        	</div>
	        </div>
	    </div>
	</div>
	@endif
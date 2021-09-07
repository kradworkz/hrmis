<div class="card-header">
	<div class="d-flex align-items-center">
		<ul class="nav nav-tabs card-header-tabs float-left mx-auto w-100">
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('employees') || Request::is('employees/*') ? 'active' : '' }}" href="{{ route('Employees') }}">Employees</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('contract') || Request::is('contract/*') ? 'active' : '' }}" href="{{ route('Employee Job Contract') }}">Job Contract</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('coc') || Request::is('coc/*') ? 'active' : '' }}" href="{{ route('COC Listings') }}">Compensatory Overtime Credits</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('travels') || Request::is('travels/*') ? 'active' : '' }}" href="{{ route('Employee Travel Orders') }}">Travel Order</a>
			</li>
			<li class="nav-item">
				<a class="nav-link hrmis-title {{ Request::is('reservations') || Request::is('reservations/*') ? 'active' : '' }}" href="{{ route('Employee Vehicle Reservations') }}">Vehicle Trips</a>
			</li>
		</ul>
	</div>
</div>
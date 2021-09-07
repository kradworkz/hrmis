<div class="card-header">
	<div class="d-flex align-items-center">
		<ul class="nav nav-tabs card-header-tabs float-left mx-auto w-100">
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/info') ? 'active' : '' }}" href="{{ route('Profile') }}">Profile</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/contract') || Request::is('profile/contract/*') ? 'active' : '' }}" href="{{ route('Job Contract') }}">Job Contract</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/health') ? 'active' : '' }}" href="{{ route('Health Declaration') }}">Health Declaration</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/quarantine') || Request::is('profile/quarantine/*') ? 'active' : '' }}" href="{{ route('Home Quarantine') }}">Home Quarantine</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/dtr') || Request::is('profile/dtr/*') ? 'active' : '' }}" href="{{ route('Daily Time Record') }}">Daily Time Record</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/override') || Request::is('profile/override/*') ? 'active' : '' }}" href="{{ route('DTR Override') }}">DTR Override</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/reservations') || Request::is('profile/reservations/*') ? 'active' : '' }}" href="{{ route('Vehicle Reservation') }}">Vehicle Reservation</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/travels') || Request::is('profile/travels/*') ? 'active' : '' }}" href="{{ route('Travel Order') }}">Travel Order</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/offset') || Request::is('profile/offset/*') ? 'active' : '' }}" href="{{ route('Offset') }}">Offset</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/leave') || Request::is('profile/leave/*') ? 'active' : '' }}" href="{{ Route('Leave') }}">Leave</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/overtime') || Request::is('profile/overtime/*') ? 'active' : '' }}" href="{{ route('Overtime Request') }}">Overtime Request</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/coc') || Request::is('profile/coc/*') ? 'active' : '' }}" href="{{ route('Compensatory Overtime Credit') }}">Compensatory Overtime Credit</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('profile/pds') || Request::is('profile/pds/*') ? 'active' : '' }}" href="{{ route('Personal Information', ['id' => \Auth::id()]) }}" target="_blank">201 File</a>
			</li>
		</ul>
	</div>
</div>
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
        	<div class="modal-body p-1">
	            <div class="list-group">
	            	<a href="{{ route('New Daily Time Record') }}" class="list-group-item list-group-item-action rounded-0">Daily Time Record</a>
					<a href="{{ route('New Reservation') }}" class="list-group-item list-group-item-action rounded-0">Vehicle Reservation</a>
					<a href="{{ route('New Travel') }}" class="list-group-item list-group-item-action rounded-0">Travel Order</a>
					<a href="{{ route('New Offset') }}" class="list-group-item list-group-item-action rounded-0">Offset</a>
					<a href="{{ route('New Overtime Request') }}" class="list-group-item list-group-item-action rounded-0">Overtime Request</a>
				</div>
        	</div>
        </div>
    </div>
</div>
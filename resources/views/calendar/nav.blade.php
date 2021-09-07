<div class="card-header">
	<div class="d-flex align-items-center">
		<ul class="nav nav-tabs card-header-tabs float-left mx-auto w-100">
			<li class="nav-item">
				<a class="nav-link {{ Request::is('calendar/vehicles') ? 'active' : '' }}" href="{{ route('Vehicle Calendar') }}">Vehicle</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('calendar/offset') ? 'active' : '' }}" href="{{ route('Offset Calendar') }}">Offset</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('calendar/travels') ? 'active' : '' }}" href="{{ route('Travel Calendar') }}">Travel Order</a>
			</li>
		</ul>
	</div>
</div>
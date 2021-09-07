<div class="card-header">
	<div class="d-flex align-items-center">
		<ul class="nav nav-tabs card-header-tabs float-left mx-auto w-100">
			<li class="nav-item">
				<a class="nav-link {{ Request::is('settings/logs') || Request::is('settings/logs/*') ? 'active' : '' }}" href="{{ route('Logs') }}">Logs</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('settings/groups') || Request::is('settings/groups/*') ? 'active' : '' }}" href="{{ route('Groups') }}">Groups</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('settings/vehicles') || Request::is('settings/vehicles/*') ? 'active' : '' }}" href="{{ route('Vehicles') }}">Vehicles</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('settings/signatory') || Request::is('settings/signatory/*') ? 'active' : '' }}" href="{{ route('Signatory') }}">Signatory</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ Request::is('settings/modules') || Request::is('settings/modules/*') ? 'active' : '' }}" href="{{ route('Modules') }}">Modules</a>
			</li>
		</ul>
	</div>
</div>
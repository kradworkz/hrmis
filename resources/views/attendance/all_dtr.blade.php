<div class="card">
	<div class="card-header text-center"><h4>Today's Attendance</h4></div>
	<div class="custom-card">
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Unit</th>
					<th>Time In</th>
					<th>Time Out</th>
				</tr>
			</thead>
			<tbody>
				@foreach($all_dtr as $dtr)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td class="text-nowrap">
							@if(in_array($dtr->employee_id, $ob))
								<i class="fa fa-map-marker-alt text-success"></i>
							@endif
							{{ $dtr->employee->full_name }}
						</td>
						<td class="text-nowrap">{{ $dtr->employee->primary_group->group->name }}</td>
						<td class="text-nowrap">{{ $dtr->time_in->format('g:i A') }}</td>
						<td class="text-nowrap">{{ $dtr->time_out !== null ? $dtr->time_out->format('g:i A') : '' }}</td>
						<td>{{ $dtr->last }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>	
	</div>
</div>
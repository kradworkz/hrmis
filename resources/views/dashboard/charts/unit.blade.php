<div class="card">
	<h6 class="card-header">
		<small class="text-primary font-weight-bold">{!! $unit->name !!}</small>
	</h6>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-sm table-borderless table-hover mb-0">
				<tbody>
				@if($label == 'Work from Home' || $label == 'Office')
					@forelse($attendance as $atd)
					<tr>
						<td>{!! $atd->employee->full_name !!}</td>
						<td {{ $atd->location == 1 ? 'class=text-right' : '' }}>{!! $atd->time_in->format('h:i A') !!}</td>
						@if($atd->location == 0)
							<td class="text-right"><i class="text-primary font-weight-bold">{!! $atd->location == 0 ? 'Work from Home' : '' !!}</i></td>
						@endif
					</tr>
					@empty
					@endforelse
				@elseif($label == 'Offset' || $label == 'Travel' || $label == 'Leave')
					@forelse($offset as $off)
					<tr>
						<td>{!! $label == 'Leave' ? $off->leave->employee->full_name : $off->employee->full_name !!}</td>
						<td class="text-right">{!! $label !!}</td>
					</tr>
					@empty
					@endforelse
				@endif
				</tbody>
			</table>
		</div>
	</div>
</div>


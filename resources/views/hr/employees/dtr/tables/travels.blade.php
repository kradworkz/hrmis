<div class="table-responsive">
	<table class="table table-sm table-hover table-borederd mb-0">
		<thead>
			<tr>
				<th>#</th>
                <th>Filed By</th>
                <th width="20%">Destination</th>
                <th>Date of Travel</th>
                <th class="text-center">Status</th>
                <th>Created At</th>
                <th class="text-right">Action</th>
			</tr>
		</thead>
		<tbody>
			@if(count($travels))
				@foreach($travels as $travel)
				<tr>
                	<td>{{ $loop->iteration }}</td>
                	<td class="w-50 mw-0 long-text text-nowrap"><a href="#" data-toggle="tooltip" data-placement="left" title="{{ $travel->travel_passenger_names() }}">{{ $travel->employee->order_by_last_name }}</a></td>
                    <td class="w-50 mw-0 long-text"><a href="#" data-toggle="tooltip" data-placement="left" data-title="{{ $travel->purpose }}">{!! nl2br($travel->destination) !!}</a></td>
                    <td class="text-nowrap">{!! $travel->travel_dates !!}</td>
                    <td class="text-center text-nowrap">{!! getStatus($travel) !!}</td>
                    <td class="text-nowrap">{!! getDateDiff($travel->created_at) !!}</td>
                    <td class="text-right">
                    	<a href="{{ route('Print Travel Order', ['id' => $travel->id]) }}" target="_blank" class="badge badge-primary rounded-0 py-1" data-toggle="tooltip" data-placement="top" title="Print">PRINT</a>
                    </td>
                </tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>
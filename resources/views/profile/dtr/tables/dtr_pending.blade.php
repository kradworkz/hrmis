@if(count($pending_dtr))
<div class="card mt-4">
    <div class="card-header mb-0">Pending Daily Time Record</div>
	<div class="table-responsive">
	    <table class="table table-hover pb-0 mb-0">
	        <thead>
	            <tr>
	                <th class="text-nowrap">#</th>
	                <th>Date</th>
	                <th>Time In</th>
	                <th>Time Out</th>
	                <th class="text-center">Status</th>
	                <th class="text-center">Encoded By</th>
	                <th class="text-right">Action</th>
	            </tr>
	        </thead>
	        <tbody>
	        	@foreach($pending_dtr as $pending)
	        	<tr>
	        		<td>{!! $loop->iteration !!}</td>
	        		<td>{!! $pending->time_in->format('F d, Y') !!}</td>
	        		<td>{!! $pending->time_in->format('h:i A') !!}</td>
	        		<td>{!! optional($pending->time_out)->format('h:i A') !!}</td>
	        		<td class="text-center">
	        			@if($pending->status == 0)
	        				<i class="text-warning"><strong>PENDING</strong></i>
	        			@elseif($pending->status == 1)
	        				<i class="text-success"><strong>APPROVED</strong></i>
	        			@elseif($pending->status == 2)
	        				<i class="text-danger"><strong>DISAPPROVED</strong></i>
	        			@endif
	        		</td>
	        		<td class="text-center">{!! $pending->encoder->full_name !!}</td>
	        		<td class="text-right">
	        			<a href="{{ route('View Daily Time Record', ['id' => $pending->id]) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye fa-fw text-info"></i></a>&nbsp
	        			<a href="{{ route('Edit Daily Time Record', ['id' => $pending->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit fa-fw"></i></a>
						<span data-href="{{ route('Delete Daily Time Record', ['id' => $pending->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
					</td>
	        	</tr>
	        	@endforeach
	        </tbody>
	    </table>
	</div>
</div>
@endif
@include('layouts.confirmation')
<div class="table table-responsive">
	<table class="table table-sm table-hover table-borderless">
		<thead>
			<tr>
				<th class="text-nowrap">Plate Number</th>
				<th>Date</th>
				<th>Destination</th>
				<th>Purpose</th>
			</tr>
		</thead>
		<tbody>
			@foreach($reservations as $reservation)
				<tr class="clickable-row" data-toggle="modal" data-target="#reservation-{{ $reservation->id }}">
					<td>{{ $reservation->vehicle == null ? 'Van Rental' : $reservation->vehicle->plate_number }}</td>
					<td class="text-nowrap">{!! $reservation->reservation_dates !!}</td>
					<td width="30%">{!! nl2br($reservation->destination) !!}</td>
					<td width="30%">{!! nl2br($reservation->purpose) !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@foreach($reservations as $reservation)
<div class="modal fade" id="reservation-{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="reservation-{{ $reservation->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <h6 class="modal-header mb-0">Vehicle Reservation</h6>
            <div class="modal-body">
                <div id="formContainer">
					<form action="{{ Auth::user()->is_assistant() ? route('Submit Vehicle Approval', ['id' => $reservation->id]) : route('Submit Comment', ['id' => $reservation->id, 'module' => 1]) }}" method="POST" autocomplete="off">
					    {{ csrf_field() }}
					    <div class="form-group">
					        <h6>Requested By: <div><i class="text-primary">{!! $reservation->employee->full_name !!}</i></div></h6>
					    </div>
					    <div class="form-group">
					        <h6>Date: <div><i class="text-primary">{!! $reservation->reservation_dates !!} @if($reservation->time != null) {!! $reservation->time !!}@endif</i></div></h6>
					    </div>
					    <div class="form-group">
					        <h6>Passengers: 
					            @foreach($reservation->passengers as $passenger)
					                <div><i class="text-primary">{!! $passenger->full_name !!}</i></div>
					            @endforeach
					        </h6>
					    </div>
					    <div class="form-group">
					        <h6>Purpose: <div><i class="text-primary">{!! nl2br($reservation->purpose) !!}</i></div></h6>
					    </div>
					    <div class="form-group">
					        <h6>Destination: <div><i class="text-primary">{!! nl2br($reservation->destination) !!}</i></div></h6>
					    </div>
					    @if($reservation->remarks != null)
					    <div class="form-group">
					        <h6>Remarks: <div><i class="text-primary">{!! nl2br($reservation->remarks) !!}</i></div></h6>
					    </div>
					    @endif
					    @if(Auth::user()->is_superuser() || Auth::user()->is_assistant())
					    <div class="form-group">
					        <label>Driver Name: </label>
					        <input type="text" name="driver_name" class="form-control form-control-sm" value="{{ old('driver_name', $reservation->driver_name) }}">
					    </div>
					    <div class="form-group">
					        <h6><i class="text-info">Action:</i> </h6>
					        <div class="custom-control custom-radio custom-control-inline">
					            <input type="radio" name="status" value="0" {{ old('status', $reservation->status == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
					            <label class="custom-control-label" for="pending">Pending</label>
					        </div>
					        <div class="custom-control custom-radio custom-control-inline">
					            <input type="radio" name="status" value="1" {{ old('status', $reservation->status == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
					            <label class="custom-control-label" for="approved">Approved</label>
					        </div>
					        <div class="custom-control custom-radio custom-control-inline">
					            <input type="radio" name="status" value="2" {{ old('status', $reservation->status == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
					            <label class="custom-control-label" for="disapproved">Disapproved</label>
					        </div>
					    </div>
					    @endif
					    <div class="form-group">
					        <label for="comment">Comment</label>
					        <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
					    </div>
					    <div class="form-group">
					        <input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
					        <a href="#" data-dismiss="modal"  class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
					    </div>
					    @include('layouts.modal_comment', ['comments' => $reservation])
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
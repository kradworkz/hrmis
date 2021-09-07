<form action="{{ route('Submit Vehicle Approval', ['id' => $id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <div class="form-group">
        <label>Vehicle: <span class="text-danger">*</span></label>
        <select name="vehicle_id" class="form-control form-control-sm">
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $reservation->vehicle_id) == $vehicle->id ? 'selected' : '' }}>{!! $vehicle->plate_number !!}</option>
            @endforeach            
        </select>
    </div>
    <div class="form-group">
        <label for="start_date">Start Date <span class="text-danger">*</span></label>
        <input type="text" name="start_date" value="{{ old('start_date', $reservation->start_date == null ? '' : $reservation->start_date->format('m/d/Y')) }}" id="start_date" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="end_date">End Date <span class="text-danger">*</span></label>
        <input type="text" name="end_date" value="{{ old('end_date', $reservation->end_date == null ? '' : $reservation->end_date->format('m/d/Y')) }}" id="end_date" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="time">Time of Departure <span class="text-danger">*</span></label>
        <input type="time" name="time" value="{{ old('time', $reservation->time) }}" id="time" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="passengers">Passenger(s) <span class="text-danger">*</span></label>
        @if(Auth::user()->is_assistant())
            <select name="passengers[]" id="passengers" class="chosen-select form-control" multiple data-placeholder="DOST IV-A Personnel">
                @foreach($employees as $employee)
                    <option value="{!! $employee->id !!}" {{ collect(old('passengers', $reservation->passengers->pluck('id') ?? []))->contains($employee->id) ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
                @endforeach
            </select>
        @else
            @foreach($reservation->passengers as $passenger)
                <span class="badge badge-primary">{!! $passenger->order_by_last_name !!}</span>
            @endforeach
        @endif
    </div>
    <div class="form-group">
        <label for="destination">Destination <span class="text-danger">*</span></label>
        <textarea name="destination" id="destination" class="form-control form-control-sm rounded-0" rows="3">{{ old('destination', $reservation->destination) }}</textarea>
    </div>
    <div class="form-group">
        <label for="purpose">Purpose <span class="text-danger">*</span></label>
        <textarea name="purpose" id="purpose" class="form-control form-control-sm rounded-0" rows="3">{{ old('purpose', $reservation->purpose) }}</textarea>
    </div>
    <div class="form-group">
        <label for="remarks">Remarks</label>
        <textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0" rows="3">{{ old('remarks', $reservation->remarks) }}</textarea>
    </div>
    <div class="form-group mb-0">
        <h6><i class="text-info">Driver: {{ $reservation->driver_name }}</i></h6>
    </div>
    @if(count($approvals))
    <hr>
    <table class="table table-sm table-condensed table-borderless table-hover">
        <tbody>
            @foreach($approvals as $approval)
                <tr>
                    <td><i>{!! $approval->employee->full_name !!}</i></td>
                    <td>
                        @if($approval->action == 0)
                            <i class="text-warning font-weight-bold">PENDING</i>
                        @elseif($approval->action == 1)
                            <i class="text-success font-weight-bold">APPROVED</i>
                        @elseif($approval->action == 2)
                            <i class="text-danger font-weight-bold">DISAPPROVED</i>
                        @endif
                    </td>
                    <td class="text-right">{!! $approval->created_at->format('F d, Y h:i A') !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    @endif
    @if(Auth::user()->is_health_officer())
    <div class="form-group">
        <h6><i class="text-info">Action:</i> </h6>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="check" value="0" {{ old('check', $reservation->check == '0' ? 'checked' : '') }} class="custom-control-input" id="health_pending">
            <label class="custom-control-label" for="health_pending">Pending</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="check" value="1" {{ old('check', $reservation->check == '1' ? 'checked' : '') }} class="custom-control-input" id="health_approved">
            <label class="custom-control-label" for="health_approved">Approved</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="check" value="2" {{ old('check', $reservation->check == '2' ? 'checked' : '') }} class="custom-control-input" id="health_disapproved">
            <label class="custom-control-label" for="health_disapproved">Disapproved</label>
        </div>
    </div>
    @endif
    @if(Auth::user()->is_superuser() || Auth::user()->is_assistant())
    <!-- <div class="form-group">
        <label>Trip Ticket: </label>
        <input type="text" name="trip_ticket" class="form-control form-control-sm" value="{{ old('trip_ticket', $reservation->trip_ticket) }}">
    </div> -->
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
    @if(Auth::user()->reservation_signatory != NULL && Auth::user()->reservation_signatory->signatory == 'Recommending')
    <div class="form-group">
        <h6><i class="text-info">Recommending:</i> </h6>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="recommending" value="0" {{ old('recommending', $reservation->recommending == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
            <label class="custom-control-label" for="pending">Pending</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="recommending" value="1" {{ old('recommending', $reservation->recommending == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
            <label class="custom-control-label" for="approved">Approved</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="recommending" value="2" {{ old('recommending', $reservation->recommending == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
            <label class="custom-control-label" for="disapproved">Disapproved</label>
        </div>
    </div>
    @endif
    @if(Auth::user()->reservation_signatory != NULL && Auth::user()->reservation_signatory->signatory == 'Approval')
    <div class="form-group">
        <h6><i class="text-info">Approval:</i> </h6>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="approval" value="0" {{ old('approval', $reservation->approval == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
            <label class="custom-control-label" for="pending">Pending</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="approval" value="1" {{ old('approval', $reservation->approval == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
            <label class="custom-control-label" for="approved">Approved</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="approval" value="2" {{ old('approval', $reservation->approval == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
            <label class="custom-control-label" for="disapproved">Disapproved</label>
        </div>
    </div>
    @endif
    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
    </div>
    <div class="form-group pt-2 mb-1">
        <input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
        <a href="{{ route('Print Trip Ticket', ['id' => $reservation->id]) }}" class="btn btn-sm btn-info btn-block rounded-0" target="_blank">Print</a>
    </div>
    @include('layouts.modal_comment', ['comments' => $reservation])
</form>
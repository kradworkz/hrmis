@if(count($reservations))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
            <tr>
            	<th>#</th>
                <th>Date of Travel</th>
                <th class="text-nowrap">Plate Number</th>
                <th class="text-nowrap">Driver</th>
                <th class="text-nowrap">Destination</th>
                <th class="text-center">Status</th>
                <th class="text-center">Created At</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
            	<td class="text-nowrap">{!! $loop->iteration !!}. <i class="fa {{ $reservation->employee_id == Auth::id() ? 'fa fa-check-circle text-success' : 'fa fa-user-circle text-primary' }} fa-fw" data-toggle="tooltip" title="{{ $reservation->employee_id == Auth::id() ? 'Created by you.' : 'Created by '.$reservation->employee->full_name.'.' }}"></i></td>
                <td class="text-nowrap"><div>{!! $reservation->reservation_dates !!}</div></td>
                <td><a class="text-primary" data-toggle="tooltip" data-placement="left" title="{{ $reservation->passenger_names() }}" href="#">{{ $reservation->vehicle == null ? '' : $reservation->vehicle->plate_number }}</a></td>
                <td class="text-nowrap">{!! $reservation->driver_name !!}</td>
                <td class="w-50 mw-0 long-text"><a class="text-primary" data-placement="left" data-toggle="tooltip" data-placement="top" title="{{ $reservation->purpose }}" href="#">{!! nl2br($reservation->destination) !!}</a></td> 
                <td class="text-center">@include('layouts.status', ['approvals' => $reservation])</td>                
                <td class="text-center text-nowrap">{!! $reservation->created_at->format('F d, Y h:i A') !!}</td>
                <td class="text-right">
                @if(Auth::user()->unit->location == 0 && $reservation->approval == 1)
                    <a data-toggle="tooltip" data-placement="top" title="Print Trip Ticket" target="_blank" href="{{ route('Print Trip Ticket', ['id' => $reservation->id]) }}"><i class="fa fa-print text-success fa-fw"></i></a>
                @endif
                @if(Request::segment(1) == 'profile')
                    @if(Auth::id() == $reservation->employee_id)
                        <a href="{{ route('Edit Reservation', ['id' => $reservation->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit fa-fw"></i></a>
                        <span data-href="{{ route('Delete Reservation', ['id' => $reservation->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
                    @else
                        <a href="{{ route('View Reservation', ['id' => $reservation->id]) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye text-dark fa-fw"></i></a>
                        <span data-href="{{ route('Remove Reservation Tag', ['id' => $reservation->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Remove Tag"><i class="fa fa-tag text-danger fa-fw"></i></a></span>
                    @endif
                @else
                    <span data-href="{{ route('Remove Reservation Tag', ['id' => $reservation->id, 'employee_id' => $id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Remove Tag"><i class="fa fa-tag text-primary fa-fw"></i></a></span>
                    <span data-href="{{ route('Delete Reservation', ['id' => $reservation->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@include('layouts.confirmation')
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-0">
            <h6 class="modal-header mb-0">Vehicle Reservation</h6>
            <div class="modal-body p-0">
                <div id="statusContainer"></div>
            </div>
        </div>
    </div>
</div>
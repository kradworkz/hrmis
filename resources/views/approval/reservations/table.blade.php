@if(count($reservations))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
        	<tr>
        		<th>#</th>
                <th>Requested By</th>
                <th>Date of Travel</th>
                <th class="text-center">Plate Number</th>
                <th>Vehicle Location</th>
                <th class="text-left">Destination</th>
                <th class="text-left">Purpose</th>
        	</tr>
        </thead>
        <tbody>
        	@foreach($reservations as $reservation)
            <tr class="clickable-row" data-toggle="modal" data-target="#approvalModal" data-url="{{ route('Edit Reservation Approval', ['id' => $reservation->id]) }}" data-view="{{ route('View Reservation Approval', ['id' => $reservation->id]) }}">
                <td class="text-nowrap">{{ $loop->iteration }}. @if($reservation->check == 1)<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-title="Approved By: {{ $reservation->covid_checked_by->full_name }}"></i>@elseif($reservation->check == 2)<i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-title="Disapproved By: {{ $reservation->covid_checked_by->full_name }}"></i>@endif</td>
                <td class="text-nowrap" width="10%"><div>{!! $reservation->employee->full_name !!}</div><small><i>{!! $reservation->created_at->diffForHumans() !!}</i></small></td>
                <td class="text-nowrap" width="10%">{!! $reservation->reservation_dates !!}</td>
                <td class="text-center" width="10%"><a href="#" class="text-decoration-none" data-toggle="tooltip" data-title="{{ $reservation->passenger_names() }}">{!! $reservation->vehicle != null ? $reservation->vehicle->plate_number : '' !!}</a></td>
                <td class="text-nowrap" width="10%">
                    @if($reservation->employee->unit->location == 0)
                            @if($reservation->location == 1)
                                <i class="fa fa-check-circle text-success" data-toggle="tooltip" data-title="Within Province"></i>
                            @else
                                <i class="fa fa-exclamation-circle text-warning" data-toggle="tooltip" data-title="Outside Province"></i>
                            @endif
                        @endif
                    {!! $reservation->vehicle == null ? 'Regional Office' : ($reservation->vehicle->group == null ? 'Regional Office' : $reservation->vehicle->group->name) !!}
                </td>
                <td class="word-break text-left" width="20%">{!! nl2br($reservation->destination) !!}</td>
                <td class="word-break text-left" width="40%">{!! nl2br($reservation->purpose) !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <span class="float-left mx-auto w-100">Vehicle Reservation</span>
                    <a href="#" target="_blank" id="viewBtn" class="badge badge-primary rounded-0">VIEW</a>
                </div>
            </div>
            <div class="modal-body">
                <div id="formContainer"></div>
            </div>
        </div>
    </div>
</div>
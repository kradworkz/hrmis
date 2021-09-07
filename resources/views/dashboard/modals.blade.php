<div class="modal fade" id="employeesModal" tabindex="-1" role="dialog" aria-labelledby="employeesModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <h6 class="card-header">
                <small class="text-primary font-weight-bold">
                    <div class="d-flex align-items-center">
                        <span class="float-left mx-auto w-100 bg-white">Employees (In Service)</span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </small>
            </h6>
            <div class="modal-body">
            	<table class="table table-borderless table-hover mb-0">
            		<tbody>
            			@forelse($employees as $employee)
            			<tr>
            				<td class="text-nowrap">{!! $employee->order_by_last_name !!}</td>
            				<td class="text-nowrap">{!! optional($employee->unit)->name !!}</td>
            				<td class="text-nowrap">{!! $employee->designation !!}</td>
            			</tr>
                        @empty
		                @endforelse
            		</tbody>
            	</table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="travelsModal" tabindex="-1" role="dialog" aria-labelledby="travelsModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-0">
            <h6 class="card-header">
                <small class="ext-primary font-weight-bold">
                    <div class="d-flex align-items-center">
                        <span class="float-left mx-auto w-100 bg-white">Employees (On Travel)</span>
                        <span class="text-nowrap">{!! Carbon\Carbon::parse($date)->format('F d, Y') !!}</span> &nbsp
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </small>
            </h6>
            <div class="modal-body">
                <table class="table table-borderless table-hover mb-0">
                    <tbody>
                        @forelse($travels as $travel)
                        <tr>
                            <td class="text-nowrap">{!! $travel->employee->order_by_last_name !!}</td>
                            <td class="text-nowrap"><a href="#" class="text-decoration-none" data-toggle="tooltip" data-title="{!! $travel->travels->mode_of_travel !!}">{!! $travel->travels->travel_dates !!}</a></td>
                            <td><a href="#" class="text-decoration-none" data-toggle="tooltip" data-title="{!! $travel->travels->purpose !!}">{!! $travel->travels->destination !!}</a></td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="vehiclesModal" tabindex="-1" role="dialog" aria-labelledby="vehiclesModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-0">
            <h6 class="card-header">
                <small class="text-primary font-weight-bold">
                    <div class="d-flex align-items-center">
                        <span class="float-left mx-auto w-100 bg-white">Vehicles (On Travel)</span>
                        <span class="text-nowrap">{!! Carbon\Carbon::parse($date)->format('F d, Y') !!}</span> &nbsp
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </small>
            </h6>
            <div class="modal-body">
                <table class="table table-borderless table-hover mb-0">
                    <tbody>
                        @forelse($vehicles as $vehicle)
                        <tr class="clickable-row" data-toggle="modal" data-target="#viewTravel" data-url="{{ route('View Dashboard Vehicle Reservation', ['id' => $vehicle->id]) }}">
                            <td class="text-nowrap"><a href="#" class="text-decoration-none" data-toggle="tooltip" data-html="true" data-title="{!! $vehicle->passenger_names() !!}">{!! optional($vehicle->vehicle)->plate_number == null ? 'Van Rental' : $vehicle->vehicle->plate_number !!}</a></td>
                            <td class="text-nowrap">{!! $vehicle->reservation_dates !!}</td>
                            <td><a href="#" class="text-decoration-none" data-toggle="tooltip" data-title="{!! $vehicle->purpose !!}">{!! $vehicle->destination !!}</a></td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="offsetModal" tabindex="-1" role="dialog" aria-labelledby="offsetModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <h6 class="card-header">
                <small class="text-primary font-weight-bold">
                    <div class="d-flex align-items-center">
                        <span class="float-left mx-auto w-100 bg-white">Employees (Offset)</span> &nbsp
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </small>
            </h6>
            <div class="modal-body">
                <table class="table table-borderless table-hover mb-0">
                    <tbody>
                        @forelse($offset as $off)
                        <tr>
                            <td class="text-nowrap">{!! $off->employee->order_by_last_name !!}</td>
                            <td class="text-nowrap">{!! $off->employee->unit->name !!}</td>
                            <td class="text-nowrap text-right">{!! $off->time !!}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <h6 class="card-header">
                <small class="text-primary font-weight-bold">
                    <div class="d-flex align-items-center">
                        <span class="float-left mx-auto w-100 bg-white">Employees (Leave)</span> &nbsp
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </small>
            </h6>
            <div class="modal-body">
                <table class="table table-borderless table-hover mb-0">
                    <tbody>
                        @forelse($leave as $l)
                        <tr>
                            <td class="text-nowrap">{!! $l->leave->employee->order_by_last_name !!}</td>
                            <td class="text-nowrap">{!! $l->leave->employee->unit->name !!}</td>
                            <td class="text-right">{!! $l->leave->type !!}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="officeModal" tabindex="-1" role="dialog" aria-labelledby="officeModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <h6 class="card-header">
                <small class="text-primary font-weight-bold">
                    <div class="d-flex align-items-center">
                        <span class="float-left mx-auto w-100 bg-white">Office Attendance</span> &nbsp
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </small>
            </h6>
            <div class="modal-body">
                <table class="table table-borderless table-hover mb-0">
                    <tbody>
                        @forelse($office as $atd)
                        <tr>
                            <td class="text-nowrap">{!! $atd->employee->order_by_last_name !!}</td>
                            <td class="text-nowrap">{!! $atd->employee->unit->name !!}</td>
                            <td class="text-right">@if($atd) {!! $atd->time_in->format('h:i A') !!} @endif</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="wfhModal" tabindex="-1" role="dialog" aria-labelledby="wfhModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <h6 class="card-header">
                <small class="text-primary font-weight-bold">
                    <div class="d-flex align-items-center">
                        <span class="float-left mx-auto w-100 bg-white">WFH Attendance</span> &nbsp
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </small>
            </h6>
            <div class="modal-body">
                <table class="table table-borderless table-hover mb-0">
                    <tbody>
                        @forelse($wfh as $atd)
                        <tr>
                            <td class="text-nowrap">{!! $atd->employee->order_by_last_name !!}</td>
                            <td class="text-nowrap">{!! $atd->employee->unit->name !!}</td>
                            <td>@if($atd) {!! $atd->time_in->format('h:i A') !!} @endif</td>
                            <td class="text-right"><i class="text-primary font-weight-bold text-decoration-none">Work from Home</i></td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewTravel" tabindex="-1" role="dialog" aria-labelledby="viewTravel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <h6 class="modal-header mb-0">Vehicle Reservation</h6>
            <div class="modal-body">
                <div id="formContainer"></div>
            </div>
        </div>
    </div>
</div>

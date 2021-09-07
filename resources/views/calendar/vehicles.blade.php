@extends('layouts.content')
	@section('content')
    <div class="card mb-3">
        @include('calendar.nav')
        <div class="card-body">
            <div class="d-flex align-items-center">
                <form action="{{ route('Vehicle Calendar') }}" class="form-inline w-100">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text rounded-0">View</span>
                        </div>
                        <select name="view" class="form-control form-control-sm rounded-0">
                            <option value="List" {{ old('view', $view) == 'List' ? 'selected' : '' }}>List</option>
                            <option value="Calendar" {{ old('view', $view) == 'Calendar' ? 'selected' : '' }}>Calendar</option>
                        </select>
                    </div>
                    @if($view == 'List')
                        <div class="input-group input-group-sm ml-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Date</span>
                            </div>
                            <input type="date" name="date" class="form-control form-control-sm rounded-0" value="{{ old('date', optional($date)->format('Y-m-d')) }}">
                        </div>
                        <div class="input-group input-group-sm ml-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Vehicle</span>
                            </div>
                            <select name="vehicle_id" class="form-control form-control-sm rounded-0">
                                <option value="">Filter by Vehicle</option>
                                @forelse($vehicles as $vehicle)
                                    <option value="{!! $vehicle->id !!}" {{ old('vehicle_id', $vehicle_id) == $vehicle->id ? 'selected' : '' }}>{!! $vehicle->vehicle_name !!}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="input-group input-group-sm ml-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Tagged</span>
                            </div>
                            <select name="tagged" class="form-control form-control-sm">
                                <option value="{{ Auth::id() }}" {{ old('tagged', $tagged) == Auth::id() ? 'selected' : '' }}>Yes</option>
                                <option value="" {{ old('tagged', $tagged) == "" ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    @else
                        <div class="input-group input-group-sm ml-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Year</span>
                            </div>
                            <select name="year" class="form-control form-control-sm rounded-0">
                                @foreach($years as $y)
                                    <option value="{!! $y !!}" {{ $year == $y ? 'selected' : (old('year') == $y ? 'selected' : '') }}>{!! $y !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group input-group-sm ml-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Month</span>
                            </div>
                            <select name="month" class="form-control form-control-sm rounded-0">
                                @foreach($months as $key => $m)
                                    <option value="{!! $key !!}" {{ $month == $key ? 'selected' : (old('month') == $key ? 'selected' : '') }}>{!! $m !!}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="input-group input-group-sm ml-2">
                        <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                    </div>
                </form>
                <!-- <h6 class="mb-0 text-nowrap"><small class="font-weight-bold">Legend: <i class="fa fa-stop text-warning"></i> Pending <i class="fa fa-stop text-primary"></i> Approved <i class="fa fa-stop text-danger"></i> Disapproved</small></h6> -->
            </div>
        </div>
    </div>
    @if($view == 'List')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                @forelse($reservations as $reservation)
                                    <tr class="{{ $loop->last ? '' : 'border-bottom' }}">
                                        <td class="d-flex">
                                            <div class="align-self-center">
                                                <a href="#"><img src="{{ asset('images/default-profile.png') }}" class="dost-image border" height="90" width="90" data-toggle="tooltip" data-title="{{ $reservation->driver_name }}"></a>
                                            </div>
                                            <div class="pl-3 py-2 d-flex flex-column w-100">
                                                <div><strong class="h6"><a href="#" class="clickable-row" data-toggle="modal" data-target="#viewTravel" data-url="{{ route('View Dashboard Vehicle Reservation', ['id' => $reservation->id]) }}">{!! $reservation->reservation_dates !!}</a></strong> (<strong class="text-danger"><i>{!! optional($reservation->vehicle)->plate_number !!}</i></strong>)</div>
                                                <p>{!! nl2br($reservation->destination) !!}</p>
                                                <div class="mt-auto">
                                                    @forelse($reservation->passengers as $passenger)
                                                        <a href="#" class="text-left"><img src="{{ $passenger->photo() }}" class="dost-image border {{ Auth::id() == $passenger->id ? 'border-success border-2' : ($reservation->employee_id == $passenger->id ? 'border-primary border-2' : '') }}" height="30" width="30" data-bs-toggle="tooltip" data-toggle="tooltip" data-title="{{ $passenger->full_name }}"></a>
                                                    @empty
                                                    @endforelse
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <div>No data found.</div>
                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">    
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th width="5%" class="align-middle text-center">{!! getMonthName($month) !!}</th>
                                    @foreach($range as $r)
                                        <th width="3%" class="text-center">{!! $r->format('d') !!}</th>
                                    @endforeach
                                </tr>
                                @foreach($vehicles as $vehicle)
                                <tr>
                                    <th class="align-middle text-center p-0">{!! $vehicle->plate_number !!}</th>
                                    @foreach($range as $r)
                                    <th class="text-center p-0 m-0">
                                        @if(hrmis\Models\Reservation::active()->where('vehicle_id', '=', $vehicle->id)->whereRaw('"'.$r->format('Y-m-d').'" between `start_date` and `end_date`')->count())
                                            <a href="#" class="clickable-row d-block h-100 w-100 text-decoration-none bg-primary text-white p-2" data-toggle="modal" data-target="#viewTravel" data-url="{{ route('View Vehicle Schedule', ['id' => $vehicle->id, 'date' => $r->format('Y-m-d')]) }}">{!! hrmis\Models\Reservation::active()->where('vehicle_id', '=', $vehicle->id)->whereRaw('"'.$r->format('Y-m-d').'" between `start_date` and `end_date`')->count() !!}</a>
                                        @else
                                            <div class="d-block h-100 w-100 text-decoration-none text-white p-2">&nbsp</div>
                                        @endif
                                    </th>
                                    @endforeach
                                </tr>
                                @endforeach
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
	@endsection
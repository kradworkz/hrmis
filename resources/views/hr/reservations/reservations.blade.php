@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('hr.nav')
					<div class="card-body">
                        <div class="d-flex align-items-center">
                            <form action="{{ route('Employee Vehicle Reservations') }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Vehicle</span>
                                    </div>
                                    <select name="vehicle_id" class="form-control form-control-sm rounded-0">
                                        <option value="">-- Select Vehicle --</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{!! $vehicle->id !!}" {{ old('vehicle_id', $vehicle_id) == $vehicle->id ? 'selected' : '' }}>{!! $vehicle->plate_number !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-sm">
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
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0">Month</span>
                                        </div>
                                        <select name="month" class="form-control form-control-sm rounded-0">
                                            @foreach($months as $key => $m)
                                                <option value="{!! $key !!}" {{ $month == $key ? 'selected' : (old('month') == $key ? 'selected' : '') }}>{!! $m !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm ml-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="text" name="search" class="form-control form-control-sm rounded-0 mr-2" placeholder="Search">
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(count($reservations))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-nowrap">Plate Number</th>
                                    <th class="text-nowrap">Name of Driver</th>
                                    <th class="text-nowrap">Date of Travel</th>
                                    <th class="text-nowrap">Destination</th>
                                    <th class="text-nowrap">Passengers</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $reservation)
                                <tr>
                                    <td class="text-nowrap">{{ $loop->iteration }}.</td>
                                    <td class="text-nowrap">{{ optional($reservation->vehicle)->plate_number }}</td>
                                    <td class="text-nowrap">{{ $reservation->driver_name }}</td>
                                    <td class="text-nowrap"><a class="text-primary" data-toggle="tooltip" data-placement="top" title="{{ $reservation->passenger_names() }}" href="#">{!! $reservation->reservation_dates !!}</a></td>
                                    <td class="w-25 mw-0 long-text"><a class="text-primary" data-toggle="tooltip" data-placement="right" title="{{ $reservation->purpose }}" href="#">{!! nl2br($reservation->destination) !!}</a></td>
                                    <td>{{ $reservation->passenger_names() }}</td>
                                    <td class="text-center text-nowrap">{!! $reservation->created_at->format('F d, Y h:i A') !!}</td>
                                    <td class="text-right">
                                    <a href="{{ route('Print Trip Ticket', ['id' => $reservation->id]) }}" data-toggle="tooltip" data-placement="top" title="Print" target="_blank"><i class="fa fa-print text-info fa-fw"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if($reservations->total() >= 100)
                    <div class="card-footer">
                        {{ $reservations->appends(Request::only('search'))->links('vendor.pagination.bootstrap-4') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
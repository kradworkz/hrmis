@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('hr.nav')
					<div class="card-body">
                        <div class="d-flex align-items-center">
                            <form action="{{ route('Employee Travel Orders') }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Employee</span>
                                    </div>
                                    <select name="employee_id" class="form-control form-control-sm rounded-0">
                                        <option value="">-- Select Employee --</option>
                                        @foreach($employees as $employee)
                                            <option value="{!! $employee->id !!}" {{ old('employee_id', $employee_id) == $employee->id ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
                                        @endforeach
                                    </select>
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
                    @if(count($travels))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-nowrap">Created By</th>
                                    <th class="text-nowrap">Date of Travel</th>
                                    <th class="text-nowrap">Destination</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($travels as $travel)
                                <tr>
                                    <td class="text-nowrap">{{ $loop->iteration }}.</td>
                                    <td class="text-nowrap">{{ $travel->employee->full_name }}</td>
                                    <td class="text-nowrap"><a class="text-primary" data-toggle="tooltip" data-placement="top" title="{{ $travel->travel_passenger_names() }}" href="#">{!! $travel->travel_dates !!}</a></td>
                                    <td class="w-50 mw-0 long-text"><a class="text-primary" data-toggle="tooltip" data-placement="right" title="{{ $travel->purpose }}" href="#">{!! nl2br($travel->destination) !!}</a></td>
                                    <td class="text-center">@include('layouts.status', ['approvals' => $travel])</td>
                                    <td class="text-center text-nowrap">{!! $travel->created_at->format('F d, Y h:i A') !!}</td>
                                    <td class="text-right">
                                    <a href="{{ route('Print Travel Order', ['id' => $travel->id]) }}" data-toggle="tooltip" data-placement="top" title="Print" target="_blank"><i class="fa fa-print text-info fa-fw"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if($travels->total() >= 100)
                    <div class="card-footer">
                        {{ $travels->appends(Request::only('search'))->links('vendor.pagination.bootstrap-4') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
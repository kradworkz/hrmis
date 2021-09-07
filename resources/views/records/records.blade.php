@extends('layouts.content')
    @section('content')
        <div class="row pb-4">
            <div class="col-md-12">
                <div class="card">
                	<h6 class="card-header">
						<small class="text-primary font-weight-bold">Records</small>
					</h6>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <form action="{{ route($route, ['id' => isset($id) ? $id : null]) }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Module</span>
                                    </div>
                                    <select name="module" class="form-control form-control-sm rounded-0" required>
                                        <option value="Travel Order" {{ old('module', $module) == 'Travel Order' ? 'selected' : '' }}>Travel Order</option>
                                        <option value="Offset" {{ old('module', $module) == 'Offset' ? 'selected' : '' }}>Offset</option>
                                        <option value="Leave" {{ old('module', $module) == 'Leave' ? 'selected' : '' }}>Leave</option>
                                        <option value="Overtime Request" {{ old('module', $module) == 'Overtime Request' ? 'selected' : '' }}>Overtime Request</option>
                                        <option value="Vehicle Reservation" {{ old('module', $module) == 'Vehicle Reservation' ? 'selected' : '' }}>Vehicle Reservation</option>
                                    </select>
                                </div>
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
                                        <span class="input-group-text rounded-0">Location</span>
                                    </div>
                                    <select name="group_id" class="form-control form-control-sm rounded-0" required>
                                        <option value="Regional Office">Regional Office</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}" {{ old('group_id', $group_id) == $group->id ? 'selected' : '' }}>{!! $group->name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-sm ml-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="text" name="search" value="{{ old('search', $search) }}" class="form-control form-control-sm rounded-0 mr-2" placeholder="Search">
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-nowrap">Date of Travel</th>
                                    <th>Destination</th>
                                    <th>Purpose</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($records as $record)
                                <tr>
                                    <td class="text-nowrap">{{ $loop->iteration }}. <i class="fa {{ $record->employee_id == Auth::id() ? 'fa fa-check-circle text-success' : 'fa fa-user-circle text-primary' }} fa-fw" data-toggle="tooltip" title="{{ $record->employee_id == Auth::id() ? 'Created by you.' : 'Created By '.$record->employee->full_name.'.' }}"></i></td>
                                    <td><a class="text-primary" data-toggle="tooltip" data-placement="top" title="{{ $record->travel_passenger_names() }}" href="#">{!! $record->travel_dates !!}</a></td>
                                    <td class=" w-25 long-text">{!! nl2br($record->destination) !!}</td>
                                    <td class="w-25">
                                        {!! $record->purpose !!}
                                    </td>
                                    <td class="text-center">@include('layouts.status', ['approvals' => $record])</td>
                                    <td class="text-center text-nowrap">{!! $record->created_at->format('F d, Y h:i A') !!}</td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($records->total() >= 50)
                    <div class="card-footer">
                        {{ $records->appends(Request::only('month', 'year', 'search', 'location', 'module', 'group_id'))->links('vendor.pagination.bootstrap-4') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
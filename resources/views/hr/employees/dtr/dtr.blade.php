@extends('layouts.content')
    @section('content')
        <div class="row">
            <div class="col-md-12 pb-4">
                <div class="card">
                    @include('hr.employees.nav')
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <form action="{{ route($route, ['id' => isset($id) ? $id : null]) }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
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
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Month</span>
                                    </div>
                                    <select name="month" class="form-control form-control-sm rounded-0">
                                        @foreach($months as $key => $m)
                                            <option value="{!! $key !!}" {{ $month == $key ? 'selected' : (old('month') == $key ? 'selected' : '') }}>{!! $m !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-sm ml-2">
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                    <a href="{{ route('Print Daily Time Record', ['id' => $employee->id, 'start_date' => $year, 'end_date' => $month, 'mode' => 1]) }}" class="btn btn-info btn-sm rounded-0 ml-2 text-nowrap" data-toggle="tooltip" data-title="Print Daily Time Record" target="_blank"><i class="fa fa-print"></i></a>
                                </div>
                            </form>
                            <div class="text-nowrap">@if($latest_coc != null) Last Update: <i class="text-primary font-weight-bold">{!! formatMonth($latest_coc->month)." ".$latest_coc->year !!}</i>. Remaining Balance: <i class="text-success font-weight-bold">{!! convertToHoursMins($employee->employee_balance_all(), '%02dh %02dm') !!}</i> @endif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php $late = 0; $earned = 0; @endphp
        <div class="row pb-4">
            <div class="col-md-5">
                <div class="card h-100 border-0">
                    <h6 class="card-header">
                        <small class="text-primary font-weight-bold">Employee Attendance</small>
                    </h6>
                    @if(count($attendance))
                    <div class="table-responsive">
                        <table class="table table-sm table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Date</th>
                                    <th></th>
                                    <th class="text-center">Time In</th>
                                    <th class="text-center">Time Out</th>
                                    <th class="text-center">No. of Minutes Earned</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendance as $dtr)
                                <tr class="clickable-row" data-toggle="modal" data-target="#formModal" data-url="{{ route('Edit Employee Attendance', ['employee_id' => $employee->id, 'dtr_id' => $dtr->id]) }}">
                                    <td class="text-nowrap">{!! $dtr->time_in->format('F d') !!}</td>
                                    <td class="text-nowrap">{!! $dtr->time_in->format('l') !!}</td>
                                    <td class="text-center">{!! $dtr->late() == 1 ? '<i class="text-danger font-weight-bold">' : '' !!} {!! $dtr->time_in->format('h:i A') !!} {!! $dtr->late() == 1 ? '</i>' : '' !!}</td>
                                    <td class="text-center">{!! optional($dtr->time_out)->format('h:i A') !!}</td>
                                    <td class="text-center">{!! $dtr->earned() !!}</td>
                                </tr>
                                @php if($dtr->late() == 1) $late++; @endphp
                                @php if($dtr->earned() != "") $earned += $dtr->earned() @endphp 
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">Total Late: {!! $late !!}</td>
                                    <td></td>
                                    <td class="text-center">Total Earned: {!! $earned !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-7">
                <div class="card h-100 border-0">
                    <h6 class="card-header">
                        <small class="text-primary font-weight-bold">Compensatory Overtime Credit</small>
                    </h6>
                    @include('hr.employees.dtr.tables.coc')
                </div>
            </div>
        </div>
        <div class="row pb-4">
            <div class="col-md-9">
                <div class="card h-100 border-0">
                    <h6 class="card-header">
                        <small class="text-primary font-weight-bold">Overtime Request</small>
                    </h6>
                    @include('hr.employees.dtr.tables.overtime')
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0">
                    <h6 class="card-header">
                        <small class="text-primary font-weight-bold">Accumulated Overtime Credits</small>
                    </h6>
                    <div class="card-body">
                        <form action="{{ route('Submit Employee COC', ['employee_id' => $employee->id, 'coc_id' => 0]) }}" method="POST" autocomplete="off">
                            {{ csrf_field() }}
                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                            <div class="form-group row h-100">
                                <div class="col-md-2 my-auto">
                                    <label for="beginning_hours" class="mb-0">Hour(s)</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="number" name="beginning_hours" class="form-control form-control-sm" value="{{ convertToHoursMins($earned, '%02d') }}">
                                </div>
                            </div>
                            <div class="form-group row h-100">
                                <div class="col-md-2 my-auto">
                                    <label for="beginning_minutes" class="mb-0">Minute(s)</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="number" name="beginning_minutes" class="form-control form-control-sm" value="{{ convertToMins($earned, '%02d') }}">
                                </div>
                            </div>
                            <div class="form-group row h-100">
                                <div class="col-md-2 my-auto">
                                    <label for="month" class="mb-0">Month</label>
                                </div>
                                <div class="col-md-10 my-auto">
                                    <label class="mb-0">{!! formatMonth($month) !!}</label>
                                    <input type="hidden" name="month" class="form-control form-control-sm" value="{{ $month }}">
                                </div>
                            </div>
                            <div class="form-group row h-100">
                                <div class="col-md-2 my-auto">
                                    <label for="month" class="mb-0">Year</label>
                                </div>
                                <div class="col-md-10 my-auto">
                                    <label class="mb-0">{!! $year !!}</label>
                                    <input type="hidden" name="year" class="form-control form-control-sm" value="{{ $year }}">
                                </div>
                                <input type="hidden" name="type" value="1">
                            </div>
                            <div class="form-group mb-0">
                                <input type="submit" name="Submit" class="btn btn-block btn-primary btn-sm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-4">
            <div class="col-md-6">
                <div class="card h-100 border-0">
                    <h6 class="card-header">
                        <small class="text-primary font-weight-bold">Travel Order</small>
                    </h6>
                    @include('hr.employees.dtr.tables.travels')
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0">
                    <h6 class="card-header">
                        <small class="text-primary font-weight-bold">Offset</small>
                    </h6>
                    @include('hr.employees.dtr.tables.offset')
                </div>
            </div>
            
        </div>

    @endsection
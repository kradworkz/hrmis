@extends('layouts.content')
    @section('content')
        <div class="row">
            <div class="col-md-12">
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
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center align-middle">#</th>
                                    <th rowspan="2" class="text-center align-middle">Period</th>
                                    <th rowspan="2" class="text-center align-middle">Particulars</th>
                                    <th colspan="4" class="text-center">Vacation Leave</th>
                                    <th colspan="4" class="text-center">Sick Leave</th>
                                    <th rowspan="2" class="text-center align-middle" width="10%">Date & Action Taken on Application for Leave</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Earned</th>
                                    <th class="text-center">Absence, Undertime w/ Pay</th>
                                    <th class="text-center">Balance</th>
                                    <th class="text-center">Absence, Undertime w/o Pay</th>
                                    <th class="text-center">Earned</th>
                                    <th class="text-center">Absence, Undertime w/ Pay</th>
                                    <th class="text-center">Balance</th>
                                    <th class="text-center">Absence, Undertime w/o Pay</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($credits as $credit)
                                <tr class="clickable-row" data-toggle="modal" data-target="#formModal" data-url="{{ route('Edit Employee Leave Credit', ['employee_id' => $employee->id, 'credit_id' => $credit->id]) }}" data-size="modal-xl">
                                    <td class="text-center">{!! $loop->iteration !!}</td>
                                    <td class="text-center">{!! date("F", mktime(0, 0, 0, $credit->month, 10)) !!} {!! $credit->year !!}</td>
                                    <td>
                                        <div class="row no-gutter">
                                            <div class="col-md-2 text-nowrap">{!! $credit->particulars !!}</div>
                                            <div class="col-md-2 text-nowrap text-right">{!! $credit->particulars != '' ? $credit->days : '' !!}</div>
                                            <div class="col-md-1 text-nowrap">{!! $credit->particulars != '' ? '-' : '' !!}</div>
                                            <div class="col-md-2 text-nowrap">{!! $credit->particulars != '' ? sprintf('%02d', $credit->hours) : '' !!}</div>
                                            <div class="col-md-1 text-nowrap">{!! $credit->particulars != '' ? '-' : '' !!}</div>
                                            <div class="col-md-2 text-nowrap">{!! $credit->particulars != '' ? sprintf('%02d', $credit->minutes) : '' !!}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">{!! $credit->vl_earned !!}</td>
                                    <td class="text-center">{!! $credit->vl_deduct !!}</td>
                                    <td class="text-center">{!! $credit->vl_balance !!}</td>
                                    <td class="text-center">{!! $credit->vl_deduct_without_pay !!}</td>
                                    <td class="text-center">{!! $credit->sl_earned !!}</td>
                                    <td class="text-center">{!! $credit->sl_deduct !!}</td>
                                    <td class="text-center">{!! $credit->sl_balance !!}</td>
                                    <td class="text-center">{!! $credit->sl_deduct_without_pay !!}</td>
                                    <td>
                                        @if($credit->leave_id != null) 
                                            @if($credit->leave->type == 'Sick Leave')
                                                SL, {!! $credit->leave->off_dates !!}
                                            @elseif($credit->leave->type == 'Vacation Leave')
                                                VL, {!! $credit->leave->off_dates !!}
                                            @else
                                                SPL, {!! $credit->leave->off_dates !!}
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection

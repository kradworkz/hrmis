@extends('layouts.content')
    @section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('hr.employees.nav')
                    <div class="card-body"></div>
                    @if(count($schedule))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-nowrap">Day</th>
                                    <th class="text-nowrap">Time In</th>
                                    <th class="text-nowrap">Time Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedule as $sched)
                                <tr class="clickable-row" data-toggle="modal" data-target="#formModal" data-url="{{ route('Edit Employee Schedule', ['employee_id' => $employee->id, 'schedule_id' => $sched->id]) }}">
                                    <td>{{ $loop->iteration }}.</td>
                                    <td class="text-nowrap">@if($sched->day == 1) Monday @elseif($sched->day == 2) Tuesday @elseif($sched->day == 3) Wednesday @elseif($sched->day == 4) Thursday @elseif($sched->day == 5) Friday @elseif($sched->day == 6) Satuday @elseif($sched->day == 7) Sunday @endif</td>
                                    <td class="text-nowrap">{!! date("h:i", strtotime($sched->time_in)) !!}</td>
                                    <td class="text-nowrap">{!! date("h:i", strtotime($sched->time_out)) !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
@extends('layouts.content')
    @section('content')
        @include('profile.cards.cards')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    @include('profile.nav')
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <form action="{{ route($route, ['id' => isset($id) ? $id : null]) }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Start Date</span>
                                    </div>
                                    <input type="text" name="start_date" id="start_date" value="{{ old('start_date', optional($start_date)->format('m/d/Y')) }}" class="form-control form-control-sm rounded-0 mr-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">End Date</span>
                                    </div>
                                    <input type="text" name="end_date" id="end_date" value="{{ old('end_date', optional($end_date)->format('m/d/Y')) }}" class="form-control form-control-sm rounded-0">
                                </div>
                                <div class="input-group input-group-sm ml-2">
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                    <a href="{{ route('Print Daily Time Record', ['id' => Auth::id(), 'start_date' => $start_date->format('Y-m-d'), 'end_date' => $end_date->format('Y-m-d'), 'mode' => 0]) }}" class="btn btn-info btn-sm rounded-0 ml-2 text-nowrap" data-toggle="tooltip" data-title="Print Daily Time Record" target="_blank"><i class="fa fa-print"></i></a>
                                    <a href="{{ route('Generate Attachments', ['id' => isset($employee) ? $employee->id : \Auth::id(), 'start_date' => $start_date->format('Y-m-d'), 'end_date' => $end_date->format('Y-m-d')]) }}" class="btn btn-secondary btn-sm rounded-0 ml-2 text-nowrap" data-toggle="tooltip" data-title="Generate Attachments" target="_blank"><i class="fa fa-download"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(count($dtr))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
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
                                @php $late = 0; $earned = 0; @endphp
                                @foreach($dtr as $d)
                                <tr>                                    
                                    <td>{!! $d->time_in->format('F d, Y') !!}</td>
                                    <td>{!! $d->time_in->format('l') !!}</td>
                                    <td class="text-center">{!! $d->late() == 1 ? '<i class="text-danger font-weight-bold">' : '' !!} {!! $d->time_in->format('h:i A') !!} {!! $d->late() == 1 ? '</i>' : '' !!}</td>
                                    <td class="text-center">{!! optional($d->time_out)->format('h:i A') !!}</td>
                                    <td class="text-center">{!! $d->earned() !!}</td>
                                </tr>
                                @php if($d->late() == 1) $late++; @endphp
                                @php if($d->earned() != "") $earned += $d->earned() @endphp 
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-nowrap text-danger" width="10%"><i class="font-weight-bold">NOTE: Indication of Late and Computation of minutes earned is automatically generated by the system.</i></td>
                                    <td><h6 class="mb-0 text-muted font-weight-bold text-center">Total Late: {!! $late !!}</h6></td>
                                    <td></td>
                                    <td><h6 class="mb-0 text-muted font-weight-bold text-center">Total Earned: {!! $earned !!}</h6></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
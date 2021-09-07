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
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(count($pending))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-nowrap">Date</th>
                                    <th class="text-center">Work Location</th>
                                    <th class="text-center">Time In</th>
                                    <th class="text-center">Time Out</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pending as $dtr)
                                <tr>                      
                                    <td>{!! $loop->iteration !!}</td>            
                                    <td>{!! $dtr->time_in->format('F d, Y') !!}</td>
                                    <td class="text-center">{!! $dtr->location == 1 ? 'Office' : 'Home' !!}</td>
                                    <td class="text-center">{!! $dtr->time_in->format('h:i A') !!}</td>
                                    <td class="text-center">{!! optional($dtr->time_out)->format('h:i A') !!}</td>
                                    <td class="text-center">{!! $dtr->status == 0 ? '<i class="text-warning font-weight-bold">Pending</i>' : '<i class="text-success font-weight-bold">Verified</i>' !!}</td>
                                    <td class="text-right">
                                        <a href="{{ route('View Daily Time Record', ['id' => $dtr->id]) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye fa-fw text-info"></i></a>
                                        @if($dtr->status != 1)
                                            <a href="{{ route('Edit Daily Time Record', ['id' => $dtr->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit fa-fw"></i></a>
                                            <span data-href="{{ route('Delete Daily Time Record', ['id' => $dtr->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @include('layouts.confirmation')
                    @endif
                </div>
            </div>
        </div>
    @endsection
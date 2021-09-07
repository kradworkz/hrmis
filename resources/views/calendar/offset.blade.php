@extends('layouts.content')
	@section('content')
    <div class="card mb-3">
        @include('calendar.nav')
        <div class="card-body">
            <div class="d-flex align-items-center">
                <form action="{{ route('Offset Calendar') }}" class="form-inline w-100">
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
                <h6 class="mb-0 text-nowrap"><small class="font-weight-bold">Legend: <i class="fa fa-stop text-primary"></i> Whole Day <i class="fa fa-stop text-info"></i> Half Day</small> </h6>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">    
                    <table class="table table-bordered mb-0">
                        @foreach($days as $key => $day)
                            <td width="14%"><h6 class="card-title mb-0"><small class="text-primary font-weight-bold">{!! $day->format('l') !!}</small></h6></td>
                            @if($key == 6) @break  @endif
                        @endforeach
                        <tr>
                        @if($first != 'Monday')
                            @for($i = 1; $i <= 7; $i++)
                                <td class="p-0" style="vertical-align: text-top !important">
                                    <div class="card border-0">
                                        @foreach($remainder as $r)
                                            @if($r->format('N') == $i)
                                            <h3 class="card-header border-0 p-2"><small class="font-weight-bold text-muted">{!! $r->format('j') !!}</small></h3>
                                            <div class="card-body p-1 calendar-height">
                                                <table class="table table-sm table-borderless mb-0">
                                                    @foreach($offset as $off)
                                                    @if($off->date->format('Y-m-d') == $r->format('Y-m-d'))
                                                        <tr>
                                                            <td><a href="#" class="badge text-left {!! $off->hours == 8 ? 'badge-primary' : 'badge-info' !!} rounded-0 w-100"><h6 class="mb-0"><small class="font-weight-bold">{!! $off->employee->full_name !!}</small></h6></a></td>
                                                        </td>
                                                    @endif
                                                @endforeach
                                                </table>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            @endfor
                        @endif
                        </tr>
                        @foreach($days as $key => $day)
                            @if($key % 7 == 0)
                                <tr valign="top">
                            @endif
                            <td class="p-0" style="vertical-align: text-top !important">
                                <div class="card border-0">
                                    <h3 class="card-header border-0 p-2"><small class="font-weight-bold text-muted">{!! $day->format('j') !!}</small></h3>
                                    <div class="card-body p-1 calendar-height">
                                        <table class="table table-sm table-borderless mb-0">
                                            @foreach($offset as $off)
                                                @if($off->date->format('Y-m-d') == $day->format('Y-m-d'))
                                                    <tr>
                                                        <td><a href="#" class="badge text-left {!! $off->hours == 8 ? 'badge-primary' : 'badge-info' !!} rounded-0 w-100"><h6 class="mb-0"><small class="font-weight-bold">{!! $off->employee->full_name !!}</small></h6></a></td>
                                                    </td>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </td>
                        @endforeach
                    </table>
                </tr>
            </div>
        </div>
    </div>
	@endsection
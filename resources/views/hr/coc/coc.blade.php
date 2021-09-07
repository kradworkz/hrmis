@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('hr.nav')
					<div class="card-body">
                        <div class="d-flex align-items-center">
                            <form action="{{ route('COC Listings') }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Employee Status</span>
                                    </div>
                                    <select name="employment_status_id" class="form-control form-control-sm rounded-0">
                                        <option value="">-- Select Option --</option>
                                        @foreach($status as $s)
                                            <option value="{!! $s->id !!}" {{ $employment_status_id == $s->id ? 'selected' : '' }}>{!! $s->name !!}</option>
                                        @endforeach
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
                    @if($coc)
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                	<th>#</th>
                                	<th>Name</th>
                                    <th>No. of Hours Earned</th>
                                    <th>Created At</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($coc as $c)
                            		<tr>
                            			<td>{!! $loop->iteration !!}</td>
                            			<td>{!! $c->employee->full_name !!}</td>
                                        <td>{!! $c->beginning_hours != 0 ? $c->beginning_hours." hour(s)" : "" !!} {!! $c->beginning_minutes != 0 ? $c->beginning_minutes." minute(s)" : "" !!}</td>
                                        <td>{!! $c->created_at->format('F d, Y h:i A') !!}</td>
                                        <td>{!! date("F", mktime(0, 0, 0, $c->month, 10)) !!}</td>
                                        <td>{!! $c->year !!}</td>
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
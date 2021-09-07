@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('hr.nav')
					<div class="card-body">
                        <div class="d-flex align-items-center">
                            <form action="{{ route('Employee Job Contract') }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
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
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(count($contracts))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-nowrap">Employee Name</th>
                                    <th class="text-nowrap">Contract Duration</th>
                                    <th class="text-nowrap">Employment Title</th>
                                    <th class="text-nowrap">Salary Rate</th>
                                    <th class="text-nowrap">Created At</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contracts as $contract)
                                    <tr>
                                        <td class="text-nowrap">{{ $loop->iteration }}.</td>
                                        <td>{!! $contract->employee->full_name !!}</td>
                                        <td>{!! $contract->contract_duration !!}</td>
                                        <td>{!! $contract->employment_title !!}</td>
                                        <td>{!! $contract->salary_rate !!}</td>
                                        <td>{!! $contract->created_at->format('F d, Y h:i A') !!}</td>
                                        <td class="text-right">
                                            <a href="{{ route('Download Job Contract', ['contract' => $contract->id]) }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download text-success fa-fw"></i></a>
                                        </td>
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
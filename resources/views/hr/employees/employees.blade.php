@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('hr.nav')
					<div class="card-body">
						<form action="{{ route('Employees') }}" class="form-inline" method="GET" autocomplete="off">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
				                    <span class="input-group-text rounded-0"><i class="fa fa-search"></i></span>
				                </div>
				                <input type="text" name="search" value="{{ old('search', $search) }}" class="form-control form-control-sm rounded-0" placeholder="Search">
							</div>
							<div class="input-group input-group-sm ml-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">Unit</span>
                                </div>
                                <select name="group_id" class="form-control form-control-sm rounded-0">
                                	<option value="">-- Select Unit --</option>
                                    @foreach($groups as $group)
                                        <option value="{!! $group->id !!}" {{ old('group_id', $unit) == $group->id ? 'selected' : '' }}>{!! $group->name !!}</option>
                                    @endforeach
                                </select>
							</div>
							<div class="input-group input-group-sm ml-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">Employment Status</span>
                                </div>
                                <select name="employee_status_id" class="form-control form-control-sm rounded-0">
                                	<option value="">-- Select Employee Status --</option>
                                    @foreach($emp_status as $employee_status)
                                        <option value="{!! $employee_status->id !!}" {{ old('employee_status_id', $status) == $employee_status->id ? 'selected' : '' }}>{!! $employee_status->name !!}</option>
                                    @endforeach
                                </select>
							</div>
							<input type="Submit" class="btn btn-primary btn-sm ml-2 rounded-0">
						</form>
					</div>
					@if(count($employees))
					<div class="table-responsive">
					    <table class="table table-hover pb-0 mb-0">
					        <thead>
					            <tr>
					                <th>#</th>
					                <th class="text-nowrap">Name</th>
					                <th>Designation</th>
					                <th>Email</th>
					                <th>Signature</th>
					                <th class="text-center">Personal Data Sheet</th>
					                <th class="text-center">Remaining COC</th>
					                <th class="text-center">Last Update</th>
					                <th class="text-center">Employment Status</th>
					                <th class="text-center">Status</th>
					            </tr>
					        </thead>
					        <tbody>
					            @foreach($employees as $employee)
					            <tr class="clickable-row" data-href="{{ route('View Employee Profile', ['id' => $employee->id]) }}" data-tab="no">
					                <td>{{ $loop->iteration }}. </td>
					                <td class="text-nowrap">{!! $employee->order_by_last_name !!}</td>
					                <td class="text-nowrap">{!! $employee->designation !!}</td>
					                <td class="text-nowrap">{!! $employee->email !!}</td>
					                <td class="text-nowrap"><a href="{!! route('Download Signature', ['signature' => $employee->signature]) !!}">{!! $employee->signature !!}</a></td>
					                <td class="text-center">@if($employee->info) <i class="fa fa-check text-success"></i> @endif</td>
					                <td class="text-nowrap text-center">{!! convertToHoursMins($employee->employee_balance_all(), '%02dh %02dm') !!}</td>
					                <td class="text-nowrap text-center">@if($employee->monthly_coc_earned != null) {!! formatMonth($employee->monthly_coc_earned->month)." ".$employee->monthly_coc_earned->year  !!} @endif</td>
					                <td class="text-nowrap text-center">{!! $employee->employment_status->name !!}</td>
					                <td class="text-center text-nowrap">{!! $employee->is_active == 1 ? '<i><small class="text-success font-weight-bold">IN SERVICE</small></i>' : '<i><small class="text-danger font-weight-bold">INACTIVE</small></i>' !!}</td>
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
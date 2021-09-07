@extends('layouts.content')
    @section('content')
    	<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="d-flex align-items-center">
							<h6 class="card-title mb-0 float-left mx-auto w-100"><small class="font-weight-bold text-primary">Daily Time Record</small></h6>
							<a href="#" class="badge badge-primary rounded-0" id="newAttendance" data-toggle="modal" data-target="#formModal" data-url="{{ route('New Employee Attendance', ['employee_id' => 0]) }}" data-toggle="popover">NEW</a>
						</div>
					</div>
					<div class="card-body d-flex align-items-center">
						<form action="{{ route('Employee DTR') }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
				                    <span class="input-group-text rounded-0"><i class="fa fa-calendar"></i></span>
				                </div>
				                <input type="text" name="date" value="{{ old('date', $date == null ? date('m/d/Y') : $date) }}" class="form-control form-control-sm rounded-0" id="date">
				                <input type="Submit" class="btn btn-primary btn-sm ml-2 rounded-0">
							</div>
						</form>
						<h6 class="mb-0 text-nowrap font-weight-bold">Date Selected: <i class="text-success">{!! $date == null ? date('F d, Y') : Carbon\Carbon::parse($date)->format('F d, Y') !!}</i></h6>
					</div>
					@if(count($dtr))
					<div class="table-responsive">
					    <table class="table table-hover pb-0 mb-0">
					        <thead>
					            <tr>
					            	<th width="30%" class="text-left">Name</th>
					                <th class="text-nowrap">Date</th>
					                <th class="text-center">Time In</th>
					                <th class="text-center">Time Out</th>
					                <th class="text-right">Work Location</th>
					            </tr>
					        </thead>
					        <tbody>
					            @foreach($dtr as $attendance)
					            <tr class="clickable-row" data-toggle="modal" data-target="#formModal" data-url="{{ route('Edit Employee Attendance', ['employee_id' => $attendance->employee->id, 'dtr_id' => $attendance->attendance_id]) }}">
					            	<td width="30%" class="text-left">{!! $attendance->employee->order_by_last_name !!}</td>
					                <td class="text-nowrap">{!! $attendance->time_in->format('F d') !!}</td>
					                <td class="text-center">{!! $attendance->time_in->format('h:i A') !!}</td>
					                <td class="text-center">{!! $attendance->time_out != null ? $attendance->time_out->format('h:i A') : '' !!}</td>
					                <td class="text-right">@if($attendance->location == 0) <i class="text-primary font-weight-bold">Work from Home</i> @endif</td>
					            </tr>
					            @endforeach
					        </tbody>
					    </table>
					</div>
					@endif
				</div>
			</div>
		</div>
		<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
		    <div class="modal-dialog modal-dialog-centered modal-md">
		        <div class="modal-content rounded-0">
		            <h6 class="modal-header mb-0">Daily Time Record</h6>
		            <div class="modal-body">
		                <div id="formContainer"></div>
		            </div>
		        </div>
		    </div>
		</div>
    @endsection
@extends('layouts.content')
	@section('content')
		<div class="row pb-2">
			<div class="col-md-6">
				<h3 class="hrmis-date text-nowrap">{!! Carbon\Carbon::parse($date)->format('F d, Y') !!}</h3>
			</div>
			<div class="col-md-6 text-right">
				@include('layouts.attendance')
			</div>
		</div>
		<div class="d-none">
			<div id="travelCount">{!! count($travels) !!}</div>
			<div id="reservationCount">{!! count($vehicles) !!}</div>
			<div id="offsetCount">{!! count($offset) !!}</div>
			<div id="officeCount">{!! count($office) !!}</div>
			<div id="wfhCount">{!! count($wfh) !!}</div>
			<div id="leaveCount">{!! count($leave) !!}</div>
		</div>
		<div class="row pb-4">
			<div class="col-md-12">
				<div class="card-deck">
					<div class="card">
						<div class="card-body">
							<div class="row h-100">
								<div class="col-md-3 my-auto"><i class="fa fa-users fa-3x text-left text-primary"></i></div>
								<div class="col-md-9 my-auto">
									<div class="d-flex align-items-end flex-column text-right h-100">
										<div class="dashboard-title">Employees</div>
										<div class="dashboard-value">{!! count($employees) !!}</div>
									</div>
								</div>
							</div>
						</div>
						<a href="#" data-toggle="modal" data-target="#employeesModal">
							<div class="card-footer clearfix">
								<div class="float-left more">VIEW DETAILS</div>
								<div class="float-right more"><i class="fa fa-angle-right"></i></div>
							</div>
						</a>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="row h-100">
								<div class="col-md-3 my-auto"><i class="fa fa-mars fa-3x text-left text-success"></i></div>
								<div class="col-md-9 my-auto">
									<div class="d-flex align-items-end flex-column text-right h-100">
										<div class="dashboard-title">Male</div>
										<div class="dashboard-value">{!! $male !!}</div>
									</div>
								</div>
							</div>
						</div>
						<a href="#">
							<div class="card-footer clearfix">
								<div class="float-left more">VIEW DETAILS</div>
								<div class="float-right more"><i class="fa fa-angle-right"></i></div>
							</div>
						</a>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="row h-100">
								<div class="col-md-3 my-auto"><i class="fa fa-venus fa-3x text-left pink"></i></div>
								<div class="col-md-9 my-auto">
									<div class="d-flex align-items-end flex-column text-right h-100">
										<div class="dashboard-title">Female</div>
										<div class="dashboard-value" >{!! $female !!}</div>
									</div>
								</div>
							</div>
						</div>
						<a href="#">
							<div class="card-footer clearfix">
								<div class="float-left more">VIEW DETAILS</div>
								<div class="float-right more"><i class="fa fa-angle-right"></i></div>
							</div>
						</a>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="row h-100">
								<div class="col-md-3 my-auto"><i class="fa fa-user-clock fa-3x text-left text-secondary"></i></div>
								<div class="col-md-9 my-auto">
									<div class="d-flex align-items-end flex-column text-right h-100">
										<div class="dashboard-title">Contract of Service</div>
										<div class="dashboard-value">{!! $cos !!}</div>
									</div>
								</div>
							</div>
						</div>
						<a href="#">
							<div class="card-footer clearfix">
								<div class="float-left more">VIEW DETAILS</div>
								<div class="float-right more"><i class="fa fa-angle-right"></i></div>
							</div>
						</a>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="row h-100">
								<div class="col-md-3 my-auto"><i class="fa fa-user-check fa-3x text-left text-info"></i></div>
								<div class="col-md-9 my-auto">
									<div class="d-flex align-items-end flex-column text-right h-100">
										<div class="dashboard-title">Permanent</div>
										<div class="dashboard-value">{!! $permanent !!}</div>
									</div>
								</div>
							</div>
						</div>
						<a href="#">
							<div class="card-footer clearfix">
								<div class="float-left more">VIEW DETAILS</div>
								<div class="float-right more"><i class="fa fa-angle-right"></i></div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row pb-4">
			<div class="col-md-12">
				<div class="card">
					<h6 class="card-header">
						<small class="text-primary font-weight-bold">Filter Data</small>
					</h6>
					<div class="card-body">
						<form action="{{ route('Dashboard') }}" class="form-inline">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
				                    <span class="input-group-text rounded-0">Date</span>
				                </div>
			                	<input type="date" name="date" value="{{ old('date', $date) }}" min="1950-01-01" max="{{ date('Y-m-d') }}" class="form-control form-control-sm" id="dashboard-date" required>
			                </div>
			                <input type="Submit" class="btn btn-primary btn-sm rounded-0 ml-2">
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row pb-4">
			<div class="col-md-8">
				<div class="card">
					<h6 class="card-header">
						<small class="text-primary font-weight-bold">No. of attendance per unit</small>
					</h6>
					<div class="card-body chart-height">
						<canvas id="attendanceChart" width="400" height="500"></canvas>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<h6 class="card-header">
						<small class="text-primary font-weight-bold">Today's Overview</small>
					</h6>
					<div class="card-body chart-height">
						<canvas id="overallChart" width="400" height="500" class="pt-2"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="chartModal" aria-hidden="true">
		    <div class="modal-dialog modal-dialog-centered modal-md">
		        <div class="modal-content rounded-0">
		            <div class="modal-body p-0">
		                <div id="formContainer"></div>
		            </div>
		        </div>
		    </div>
		</div>
		@include('dashboard.modals')
	@endsection
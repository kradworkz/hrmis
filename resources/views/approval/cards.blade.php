<div class="row mb-3">
	<div class="col-md-12">
		<div class="card-deck">
			<div class="card">
				<div class="card-body">
					<div class="row h-100">
						<div class="col-md-3 my-auto"><i class="fa fa-bus fa-3x text-left text-primary"></i></div>
						<div class="col-md-9 my-auto">
							<div class="d-flex align-items-end flex-column text-right h-100">
								<div class="dashboard-title">Approved Vehicle Trips <div>({!! $start->format('F')."-".$end->format('F')." ".$year !!})</div></div>
								<div class="dashboard-value">{!! $reservations !!}</div>
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
						<div class="col-md-3 my-auto"><i class="fa fa-plane-departure fa-3x text-left text-info"></i></div>
						<div class="col-md-9 my-auto">
							<div class="d-flex align-items-end flex-column text-right h-100">
								<div class="dashboard-title">Approved Travel Order <div>({!! $start->format('F')."-".$end->format('F')." ".$year !!})</div></div>
								<div class="dashboard-value">{!! $travels !!}</div>
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
						<div class="col-md-3 my-auto"><i class="fa fa-clock fa-3x text-left text-danger"></i></div>
						<div class="col-md-9 my-auto">
							<div class="d-flex align-items-end flex-column text-right h-100">
								<div class="dashboard-title">Approved Offset <div>({!! $start->format('F')."-".$end->format('F')." ".$year !!})</div></div>
								<div class="dashboard-value">{!! $offset !!}</div>
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
						<div class="col-md-3 my-auto"><i class="fa fa-tired fa-3x text-left text-secondary"></i></div>
						<div class="col-md-9 my-auto">
							<div class="d-flex align-items-end flex-column text-right h-100">
								<div class="dashboard-title">Approved Leave <div>({!! $start->format('F')."-".$end->format('F')." ".$year !!})</div></div>
								<div class="dashboard-value">{!! $leave !!}</div>
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
						<div class="col-md-3 my-auto"><i class="fa fa-business-time fa-3x text-left text-warning"></i></div>
						<div class="col-md-9 my-auto">
							<div class="d-flex align-items-end flex-column text-right h-100">
								<div class="dashboard-title">Overtime Request <div>({!! $start->format('F')."-".$end->format('F')." ".$year !!})</div></div>
								<div class="dashboard-value">
									{!! $overtime !!}
								</div>
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
		</div>
	</div>
</div>
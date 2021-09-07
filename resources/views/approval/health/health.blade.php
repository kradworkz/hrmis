@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('approval.nav')
					<div class="card-body">
						<div class="d-flex align-items-center">
					        <form action="{{ route($route, ['id' => isset($id) ? $id : null]) }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
					            <div class="input-group input-group-sm">
				                    <div class="input-group-prepend">
				                        <span class="input-group-text rounded-0">Date</span>
				                    </div>
				                   	<input type="date" name="date" class="form-control form-control-sm" min="1950-01-01" max="{{ date('Y-m-d') }}" value="{{ old('date', $date) }}">
					            </div>
					            <input type="Submit" class="btn btn-primary btn-sm rounded-0 ml-2">
					        </form>
					    </div>
					</div>
					@if(count($risks))
						<div class="table-responsive">
							<table class="table table-hover pb-0 mb-0">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Name</th>
										<th class="text-center">Temperature</th>
										<th class="text-center">Fever</th>
										<th class="text-center">Cough</th>
										<th class="text-center">Aches and Pains</th>
										<th class="text-center">Runny Nose</th>
										<th class="text-center">Shortness of Breath</th>
										<th class="text-center">Diarrhea</th>
										<th class="text-center">Sore Throat</th>
										<th class="text-center">Loss of Taste/Smell</th>
										<th class="text-center">Close Contact</th>
										<th class="text-center">Traveled Outside</th>
									</tr>
								</thead>
								<tbody>
									@foreach($risks as $risk)
										<tr class="clickable-row" data-target="#approvalModal" data-toggle="modal" data-url="{{ route('View Health Check Approval', ['id' => $risk->id]) }}">
											<td>{!! $loop->iteration !!}</td>
											<td>{!! $risk->date->format('F d, Y') !!}</td>
											<td>{!! $risk->employee->full_name !!}</td>
											<td class="text-center">{!! $risk->temperature !!}</td>
											<td class="text-center">{!! $risk->fever != NULL ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
											<td class="text-center">{!! $risk->cough != NULL ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
											<td class="text-center">{!! $risk->ache != NULL ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
											<td class="text-center">{!! $risk->runny_nose != NULL ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
											<td class="text-center">{!! $risk->shortness_of_breath != NULL ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
											<td class="text-center">{!! $risk->diarrhea != NULL ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
											<td class="text-center">{!! $risk->sore_throat != NULL ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
											<td class="text-center">{!! $risk->loss_of_taste != NULL ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
											<td class="text-center">{!! $risk->q2 != NULL ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
											<td class="text-center">{!! $risk->q4 != NULL ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
					<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModal" aria-hidden="true">
					    <div class="modal-dialog modal-dialog-centered modal-lg">
					        <div class="modal-content rounded-0">
					            <div class="card-header">
					                <div class="d-flex align-items-center">
					                    <span class="float-left mx-auto w-100">Health Check</span>
					                </div>
					            </div>
					            <div class="modal-body">
					                <div id="formContainer"></div>
					            </div>
					        </div>
					    </div>
					</div>
				</div>
			</div>
		</div>

	@endsection

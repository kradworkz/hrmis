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
				                        <span class="input-group-text rounded-0">Status</span>
				                    </div>
				                    @if(Auth::user()->is_superuser() || Auth::user()->is_health_officer() || Auth::user()->is_hr())
				                    	<select name="status" class="form-control form-control-sm rounded-0">
					                        <option value="1" {{ old('status', $status) == 1 ? 'selected' : '' }}>Active</option>
					                        <option value="0" {{ old('status', $status) == 0 ? 'selected' : '' }}>Recovered</option>
					                    </select>
				                    @else
					                    <select name="status" class="form-control form-control-sm rounded-0">
					                        <option value="0" {{ old('status', $status) == 0 ? 'selected' : '' }}>Pending</option>
					                        <option value="1" {{ old('status', $status) == 1 ? 'selected' : '' }}>Approved</option>
					                        <option value="2" {{ old('status', $status) == 2 ? 'selected' : '' }}>Disapproved</option>
					                    </select>
				                    @endif
				                    
					             </div>
					            <input type="Submit" class="btn btn-primary btn-sm rounded-0 ml-2">
					        </form>
					    </div>
					</div>
					@if(count($quarantine))
						<div class="table-responsive">
							<table class="table table-hover pb-0 mb-0">
								<thead>
									<tr>
										<th>#</th>
										<th>Employee Name</th>
										<th>Date Declared</th>
										<th>Endorsed By</th>
										<th>Recommendation</th>
										<th>Remarks</th>
										<th class="text-center">Temperature</th>
										<th>Health Declaration</th>
										<th>Medical Certificate</th>
									</tr>
								</thead>
								<tbody>
									@foreach($quarantine as $q)
										<tr class="clickable-row" data-target="#approvalModal" data-toggle="modal" data-url="{{ route('Edit Employee Quarantine', ['id' => $q->id]) }}" data-view="{{ route('View Employee Quarantine', ['id' => $q->id]) }}">
											<td>{!! $loop->iteration !!}</td>
											<td>{!! $q->employee->full_name !!}</td>
											<td>{!! $q->health_declaration->date->format('F d, Y') !!}</td>
											<td>{!! $q->endorsed->full_name !!}</td>
											<td>{!! $q->recommendation !!}</td>
											<td>{!! $q->remarks !!}</td>
											<td class="text-center">{!! $q->health_declaration->temperature !!}</td>
											<td>
												<span class="badge badge-primary">{{ $q->health_declaration->fever }}</span> 
									            <span class="badge badge-danger">{{ $q->health_declaration->cough }}</span> 
									            <span class="badge badge-info">{{ $q->health_declaration->ache != NULL ? 'Aches and Pains' : '' }}</span> 
									            <span class="badge badge-secondary">{{ $q->health_declaration->runny_nose }}</span> 
									            <span class="badge badge-warning">{{ $q->health_declaration->shortness_of_breath }}</span> 
									            <span class="badge badge-success">{{ $q->health_declaration->diarrhea }}</span>
									            <span class="badge bg-light">{{ $q->health_declaration->sore_throat }}</span>
									            <span class="badge badge-dark">{{ $q->health_declaration->loss_of_taste }}</span>
											</td>
											<td>
												@foreach($q->attachments as $attachment)
							                        <div><a class="text-decoration-none" href="{{ route('Get File Attachment', ['filename' => $attachment->filename]) }}" target="_blank">{!! $attachment->title !!}</a></div>
							                    @endforeach
											</td>
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
					                    <span class="float-left mx-auto w-100">Employee Quarantine</span>
					                    <a href="#" target="_blank" id="viewBtn" class="badge badge-primary rounded-0">VIEW</a>
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

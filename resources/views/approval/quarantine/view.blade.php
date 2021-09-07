@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Employee Quarantine Approval') }}"><small class="text-primary font-weight-bold">Employee Quarantine</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Employee Quarantine Approval', ['id' => $id]) }}" method="POST" autocomplete="off">
						    {{ csrf_field() }}
						    @if(Auth::user()->is_superuser() || Auth::user()->is_health_officer())
						        <div class="form-group mb-0">
						            <label>Employee: <i class="text-primary font-weight-bold">{!! $quarantine->employee->full_name !!}</i></label>
						        </div>
						        <div class="form-group mb-0">
						            <label>Symptoms:
						                <span class="badge badge-primary">{{ $quarantine->health_declaration->fever }}</span> 
						                <span class="badge badge-danger">{{ $quarantine->health_declaration->cough }}</span> 
						                <span class="badge badge-info">{{ $quarantine->health_declaration->ache }}</span> 
						                <span class="badge badge-secondary">{{ $quarantine->health_declaration->runny_nose }}</span> 
						                <span class="badge badge-warning">{{ $quarantine->health_declaration->shortness_of_breath }}</span> 
						                <span class="badge badge-success">{{ $quarantine->health_declaration->diarrhea }}</span>
						            </label>
						        </div>
						        <div class="form-group mb-0">
						            <label>Temperature: <i class="text-primary font-weight-bold">{!! $quarantine->health_declaration->temperature !!}</i></label>
						        </div>
						        <div class="form-group">
						            <label>Recommendations: </label>
						            <div class="custom-control custom-radio">
						                <input type="radio" name="recommendation" value="14 days quarantine" {{ $quarantine->recommendation == '14 days quarantine' ? 'checked' : '' }} class="custom-control-input" id="14dquarantine" required>
						                <label class="custom-control-label" for="14dquarantine">14 days quarantine</label>
						            </div>
						            <div class="custom-control custom-radio">
						                <input type="radio" name="recommendation" value="7 days quarantine" {{ $quarantine->recommendation == '7 days quarantine' ? 'checked' : '' }} class="custom-control-input" id="7dquarantine" required>
						                <label class="custom-control-label" for="7dquarantine">7 days quarantine</label>
						            </div>
						            <div class="custom-control custom-radio">
						                <input type="radio" name="recommendation" value="May continue reporting to office" {{ $quarantine->recommendation == 'May continue reporting to office' ? 'checked' : '' }} class="custom-control-input" id="office" required>
						                <label class="custom-control-label" for="office">May continue reporting to office</label>
						            </div>
						        </div>
						        <div class="form-group">
						            <label for="start_date">Start Date</label>
						            <input type="date" name="start_date" min="1950-01-01" value="{{ old('start_date', $quarantine->start_date != NULL ? $quarantine->start_date->format('Y-m-d') : '') }}" class="form-control form-control-sm">
						        </div>
						        <div class="form-group">
						            <label for="end_date">End Date</label>
						            <input type="date" name="end_date" min="1950-01-01" value="{{ old('end_date', $quarantine->end_date != NULL ? $quarantine->end_date->format('Y-m-d') : '') }}" class="form-control form-control-sm">
						        </div>
						        <div class="form-group">
						            <label for="remarks">Remarks</label>
						            <textarea name="remarks" class="form-control form-control-sm rounded-0" rows="3">{!! $quarantine->remarks !!}</textarea>
						        </div>
						        <div class="form-group">
						            <div class="custom-control custom-checkbox">
						                <input type="checkbox" name="monitor_health" value="1" {{ $quarantine->monitor_health != 0 ? "checked" : "" }} class="custom-control-input" id="monitor_health">
						                <label class="custom-control-label" for="monitor_health">Monitor Symptoms</label>
						            </div>
						        </div>
						        <div class="form-group">
						            <div class="custom-control custom-checkbox">
						                <input type="checkbox" name="report_local" value="1" {{ $quarantine->report_local != 0 ? "checked" : "" }} class="custom-control-input" id="report_local">
						                <label class="custom-control-label" for="report_local">Report to Local Health Authorities</label>
						            </div>
						        </div>
						        <div class="form-group">
						            <div class="custom-control custom-checkbox">
						                <input type="checkbox" name="medical_certificate" value="1" {{ $quarantine->medical_certificate != 0 ? "checked" : "" }} class="custom-control-input" id="medical_certificate">
						                <label class="custom-control-label" for="medical_certificate">Secure Medical Certificate</label>
						            </div>
						        </div>
						    @else
						        <div class="form-group mb-0">
						            <label>Employee: <i class="text-primary font-weight-bold">{!! $quarantine->employee->full_name !!}</i></label>
						        </div>
						        <div class="form-group mb-0">
						            <label>Endorsed By: <i class="text-primary font-weight-bold">{!! $quarantine->endorsed->full_name !!}</i></label>
						        </div>
						        <div class="form-group mb-0">
						        	<label>Symptoms:
						                <span class="badge badge-primary">{{ $quarantine->health_declaration->fever }}</span> 
						                <span class="badge badge-danger">{{ $quarantine->health_declaration->cough }}</span> 
						                <span class="badge badge-info">{{ $quarantine->health_declaration->ache }}</span> 
						                <span class="badge badge-secondary">{{ $quarantine->health_declaration->runny_nose }}</span> 
						                <span class="badge badge-warning">{{ $quarantine->health_declaration->shortness_of_breath }}</span> 
						                <span class="badge badge-success">{{ $quarantine->health_declaration->diarrhea }}</span>
						            </label>
						        </div>
						        <div class="form-group mb-0">
						            <label>Temperature: <i class="text-primary font-weight-bold">{!! $quarantine->health_declaration->temperature !!}</i></label>
						        </div>
						        <div class="form-group mb-0">
						        	<label>Recommendations: <i class="text-primary font-weight-bold">{{ $quarantine->recommendation }}</i></label>
						        </div>
						        <div class="form-group mb-0">
						        	<label>Quarantine Date(s): <i class="text-primary font-weight-bold">{{ $quarantine->quarantine_dates }}</i></label>
						        </div>
						        <div class="form-group mb-0">
						            <label>Monitor Symptoms: {!! $quarantine->monitor_health ? '<i class="text-primary font-weight-bold">Yes</i>' : 'No' !!}</label>
						        </div>
						        <div class="form-group mb-0">
						            <label>Medical Certificate: {!! $quarantine->medical_certificate ? '<i class="text-primary font-weight-bold">Yes</i>' : 'No' !!}</label>
						        </div>
						        <div class="form-group mb-0">
						            <label>Report to Local Health Authorities: {!! $quarantine->report_local ? '<i class="text-primary font-weight-bold">Yes</i>' : 'No' !!}</label>
						        </div>
						        <div class="form-group mb-0">
						            <label>Remarks: <i class="text-primary font-weight-bold">{{ $quarantine->remarks }}</i></label>
						        </div>
						    @endif 
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-body py-3 px-4">
						<div class="comment-box">
							@if(count($quarantine->comments))
								@foreach($quarantine->comments as $comment)
									<div class="row py-2">
										<div class="col-md-2 text-center">
											<div class="frame rounded-circle">
												<img src="{{ $comment->employee->picture == null ? asset('profile/default-profile.png') : asset('profile/'.$comment->employee->picture) }}" class="comment-image" width="100" height="100">
											</div>
										</div>
										<div class="col-md-10 d-flex flex-column">
											<div class="d-block w-100"><span class="text-primary font-weight-bold">{!! $comment->employee->full_name !!}</span> <a href="{{ route('Delete Comment', ['id' => $comment->id]) }}" class="float-right pr-2 {{ $comment->employee->id != Auth::id() ? 'd-none' : '' }}" data-toggle="tooltip" data-placement="top" title="Delete Comment"><i class="fa fa-comment-slash text-danger"></i></a></div>
											<p class="text-justify">{!! $comment->comment !!}</p>
											<div class="d-block mt-auto text-muted"><small>{!! getDateDiff($comment->updated_at) !!}</small></div>
										</div>
									</div>
									@if(!$loop->last)<hr>@endif
								@endforeach
							@endif
						</div>
					</div>
					<div class="card-footer rounded-0">
						@if(count($approvals))
					    <table class="table table-sm table-condensed table-borderless table-hover">
					        <tbody>
					            @foreach($approvals as $approval)
					                <tr>
					                    <td><i>{!! $approval->employee->full_name !!}</i></td>
					                    <td>
					                        @if($approval->action == 0)
					                            <i class="text-warning font-weight-bold">PENDING</i>
					                        @elseif($approval->action == 1)
					                            <i class="text-success font-weight-bold">APPROVED</i>
					                        @elseif($approval->action == 2)
					                            <i class="text-danger font-weight-bold">DISAPPROVED</i>
					                        @endif
					                    </td>
					                    <td class="text-right">{!! $approval->created_at->format('F d, Y h:i A') !!}</td>
					                </tr>
					            @endforeach
					        </tbody>
					    </table>
					    @endif
					    @if(Auth::user()->health_signatory != NULL && Auth::user()->health_signatory->signatory == 'Unit Head')
					        <div class="form-group">
					            <h6><i class="text-info">Approval:</i> </h6>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="unit_head" value="0" {{ old('unit_head', $quarantine->unit_head == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
					                <label class="custom-control-label" for="pending">Pending</label>
					            </div>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="unit_head" value="1" {{ old('unit_head', $quarantine->unit_head == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
					                <label class="custom-control-label" for="approved">Approved</label>
					            </div>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="unit_head" value="2" {{ old('unit_head', $quarantine->unit_head == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
					                <label class="custom-control-label" for="disapproved">Disapproved</label>
					            </div>
					        </div>
					    @elseif(Auth::user()->health_signatory != NULL && Auth::user()->health_signatory->signatory == 'Recommending')
					        <div class="form-group">
					            <h6><i class="text-info">Recommending:</i> </h6>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="recommending_to" value="0" {{ old('recommending_to', $quarantine->recommending_to == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
					                <label class="custom-control-label" for="pending">Pending</label>
					            </div>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="recommending_to" value="1" {{ old('recommending_to', $quarantine->recommending_to == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
					                <label class="custom-control-label" for="approved">Approved</label>
					            </div>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="recommending_to" value="2" {{ old('recommending_to', $quarantine->recommending_to == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
					                <label class="custom-control-label" for="disapproved">Disapproved</label>
					            </div>
					        </div>
					    @elseif(Auth::user()->health_signatory != NULL && Auth::user()->health_signatory->signatory == 'Recommending FAS')
					        <div class="form-group">
					            <h6><i class="text-info">Recommending:</i> </h6>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="recommending_fas" value="0" {{ old('recommending_fas', $quarantine->recommending_fas == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
					                <label class="custom-control-label" for="pending">Pending</label>
					            </div>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="recommending_fas" value="1" {{ old('recommending_fas', $quarantine->recommending_fas == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
					                <label class="custom-control-label" for="approved">Approved</label>
					            </div>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="recommending_fas" value="2" {{ old('recommending_fas', $quarantine->recommending_fas == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
					                <label class="custom-control-label" for="disapproved">Disapproved</label>
					            </div>
					        </div>
					    @elseif(Auth::user()->health_signatory != NULL && Auth::user()->health_signatory->signatory == 'Approval')
					        <div class="form-group">
					            <h6><i class="text-info">Approval:</i> </h6>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="approval" value="0" {{ old('approval', $quarantine->approval == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
					                <label class="custom-control-label" for="pending">Pending</label>
					            </div>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="approval" value="1" {{ old('approval', $quarantine->approval == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
					                <label class="custom-control-label" for="approved">Approved</label>
					            </div>
					            <div class="custom-control custom-radio custom-control-inline">
					                <input type="radio" name="approval" value="2" {{ old('approval', $quarantine->approval == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
					                <label class="custom-control-label" for="disapproved">Disapproved</label>
					            </div>
					        </div>
					    @endif
						<div class="form-group">
                            <label for="commentBox">Comment</label>
                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Employee Quarantine Approval') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
					</form>
				</div>
			</div>
		</div>
	@endsection
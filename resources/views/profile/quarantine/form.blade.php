@extends('layouts.content')
	@section('content')
		@include('profile.cards.cards')
		<div class="row mt-3">
			<div class="col-md-12">
				<div class="card h-100">
					@include('profile.nav')
					<div class="card-body">
						<form action="{{ route('Submit Medical Certificate', ['id' => $quarantine->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
							{{ csrf_field() }}
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
					            <label>Remarks: <i class="text-primary font-weight-bold">{{ $quarantine->remarks }}</i></label>
					        </div>
					        <div class="form-group mb-0">
					            <label>Monitor Symptoms: {!! $quarantine->monitor_health ? '<i class="text-primary font-weight-bold">Yes</i>' : '<i class="text-primary font-weight-bold">No</i>' !!}</label>
					        </div>
					        <div class="form-group mb-0">
					            <label>Medical Certificate: {!! $quarantine->medical_certificate ? '<i class="text-primary font-weight-bold">Yes</i>' : '<i class="text-primary font-weight-bold">No</i>' !!}</label>
					        </div>
					        <div class="form-group mb-0">
					            <label>Report to Local Health Authorities: {!! $quarantine->report_local ? '<i class="text-primary font-weight-bold">Yes</i>' : '<i class="text-primary font-weight-bold">No</i>' !!}</label>
					        </div>
					        <div class="form-group">
					        	<label>Medical Certificate <span class="text-danger">*</span></label>
								<input type="file" name="attachments" class="form-control-file" required>
					        </div>
					        @if(count($approvals))
						    <hr>
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
						    <hr>
						    @endif
					        <div class="form-group mb-1">
	                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block" {{ $quarantine->end_date != null ? ($quarantine->end_date > date('Y-m-d') ? 'disabled' : '') : '' }}>
	                            <a href="{{ route('Home Quarantine') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
	                        </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endsection
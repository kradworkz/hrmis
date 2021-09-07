@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-6">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Offset') }}"><small class="text-primary font-weight-bold">Profile</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Comment', ['id' => $id, 'module' => 3])  }}" method="POST" autocomplete="off">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="date">Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('date') }}</i></label>
							<input type="text" name="date" value="{{ old('date', $offset->date == null ? '' : $offset->date->format('m/d/Y')) }}" id="date" class="form-control form-control-sm" disabled>
						</div>
						<div class="form-group">
							<label for="time">Time <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time') }}</i></label>
							<select name="time" id="time" class="form-control form-control-sm" disabled>
								@foreach($time as $t)
									<option value="{{ $t }}" {{ old('time', $offset->time) == $t ? 'selected' : '' }}>{{ $t }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="remarks">Remarks <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('remarks') }}</i></label>
							<textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0" rows="3" disabled>{{ old('remarks', $offset->remarks) }}</textarea>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label for="balance">Balance: <i class="font-weight-bold text-primary">{!! \Auth::user()->employee_coc != null ? \Auth::user()->employee_coc->end_hours." hour(s)" : '' !!}</i></label>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-0">
									<label for="covid">Covid Positive: {!! $offset->is_positive == 1 ? '<i class="font-weight-bold text-danger">Yes</i>' : 'No' !!} </label>
								</div>
								<div class="form-group mb-0">
									<label for="rtpcr">Attachments: 
										@if($offset->attachment)
											<a class="text-decoration-none" href="{{ route('Get File Attachment', ['filename' => $offset->attachment->filename]) }}" target="_blank"><i class="font-weight-bold">{!! $offset->attachment->title !!}</i></a>
										@endif
									</label>
								</div>
								<div class="form-group">
									<label class="font-weight-bold text-danger">NOTE: Compensatory Overtime Credits wont be deducted for COVID19 Positive Employees. Just declare the Radio Box Option to "Yes" and attach the RT-PCR result.</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card h-100">
					<div class="card-body py-3 px-4">
						@include('layouts.comment', ['comments' => $offset])
					</div>
					<div class="card-footer rounded-0">
						<div class="form-group">
                            <label for="commentBox">Comment</label>
                            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Offset') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
                    </form>
				</div>
			</div>
		</div>
	@endsection
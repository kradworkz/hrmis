@extends('layouts.content')
	@section('content')
		<div class="row mt-3">
			<div class="col-md-12">
				<div class="card h-100">
					<h6 class="card-header font-weight-normal text-muted"><a class="hrmis-title text-decoration-none" href="{{ route('Job Contract') }}"><small class="text-primary font-weight-bold">Job Contract</small></a> <i class="fa fa-angle-double-right fa-xs"></i> <small class="text-muted font-weight-bold">{{ Route::currentRouteName() }}</small></h6>
					<div class="card-body">
						<form action="{{ route('Submit Job Contract', ['id' => $id]) }}" method="POST" autocomplete="off">
						{{ csrf_field() }}
						<div class="form-group row">
							<div class="col-md-6">
								<label for="agency_head_name">Agency Head Name <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. JUAN C. DELA CRUZ</i> <i class="text-danger font-weight-bold">{{ $errors->first('agency_head_name') }}</i></label>
								<input type="text" name="agency_head_name" value="{{ old('agency_head_name', $contract->agency_head_name) }}" id="agency_head_name" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-6">
								<label for="agency_head_designation">Agency Head Designation <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. Regional Director</i> <i class="text-danger font-weight-bold">{{ $errors->first('agency_head_designation') }}</i></label>
								<input type="text" name="agency_head_designation" value="{{ old('agency_head_designation', $contract->agency_head_designation) }}" id="agency_head_designation" class="form-control form-control-sm" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label for="employment_title">Employee Position Title <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('employment_title') }}</i></label>
								<input type="text" name="employment_title" value="{{ old('employment_title', $contract->employment_title) }}" id="employment_title" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-4">
								<label for="contract_duration">Contract Duration <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. January 6, 2020 to June 30, 2020</i> <i class="text-danger font-weight-bold">{{ $errors->first('contract_duration') }}</i></label>
								<input type="text" name="contract_duration" value="{{ old('contract_duration', $contract->contract_duration) }}" id="contract_duration" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-4">
								<label for="salary_rate">Salary Rate <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. P13,000.00</i> <i class="text-danger font-weight-bold">{{ $errors->first('salary_rate') }}</i></label>
								<input type="text" name="salary_rate" value="{{ old('salary_rate', $contract->salary_rate) }}" id="salary_rate" class="form-control form-control-sm" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<label for="duties_and_responsibilities">Duties and Responsibilities <span class="text-danger">*</span> <i class="text-info font-weight-bold">Enumerate Duties and Responsibilities</i> <i class="text-danger font-weight-bold">{{ $errors->first('duties_and_responsibilities') }}</i></label>
								<textarea name="duties_and_responsibilities" id="duties_and_responsibilities" class="form-control form-control-sm rounded-0" rows="5" required>{{ old('duties_and_responsibilities', $contract->duties_and_responsibilities) }}</textarea>
							</div>
							<div class="col-md-6">
								<div class="form-group row">
									<div class="col-md-12">
										<label for="first_party_name">Agency Head Name <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. JUAN C. DELA CRUZ</i> <i class="text-danger font-weight-bold">{{ $errors->first('first_party_name') }}</i></label>
										<input type="text" name="first_party_name" value="{{ old('first_party_name', $contract->first_party_name) }}" id="first_party_name" class="form-control form-control-sm" required>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-md-12">
										<label for="second_party_name">Employee Name <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. MARIE A. DELA PAZ</i> <i class="text-danger font-weight-bold">{{ $errors->first('second_party_name') }}</i></label>
										<input type="text" name="second_party_name" value="{{ old('second_party_name', $contract->second_party_name) }}" id="second_party_name" class="form-control form-control-sm" required>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label for="first_witness_name">First Witness Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('first_witness_name') }}</i></label>
								<input type="text" name="first_witness_name" value="{{ old('first_witness_name', $contract->first_witness_name) }}" id="first_witness_name" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-3">
								<label for="first_witness_designation">Position Title <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('first_witness_designation') }}</i></label>
								<input type="text" name="first_witness_designation" value="{{ old('first_witness_designation', $contract->first_witness_designation) }}" id="first_witness_designation" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-3">
								<label for="second_witness_name">Second Witness Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('second_witness_name') }}</i></label>
								<input type="text" name="second_witness_name" value="{{ old('second_witness_name', $contract->second_witness_name) }}" id="second_witness_name" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-3">
								<label for="second_witness_designation">Position Title <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('second_witness_designation') }}</i></label>
								<input type="text" name="second_witness_designation" value="{{ old('second_witness_designation', $contract->second_witness_designation) }}" id="second_witness_designation" class="form-control form-control-sm" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="charging">Charged To <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. Deployment of LGU IDS in selected LGUs in the region (19-001-03-00004-001-03-12-4)</i> <i class="text-danger font-weight-bold">{{ $errors->first('charging') }}</i></label>
								<input type="text" name="charging" value="{{ old('charging', $contract->charging) }}" id="charging" class="form-control form-control-sm" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label for="current_budget_officer_name">Current Budget Officer Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('current_budget_officer_name') }}</i></label>
								<input type="text" name="current_budget_officer_name" value="{{ old('current_budget_officer_name', $contract->current_budget_officer_name) }}" id="current_budget_officer_name" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-3">
								<label for="current_budget_officer_designation">Current Budget Officer Designation <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. Admin Officer V</i> <i class="text-danger font-weight-bold">{{ $errors->first('current_budget_officer_designation') }}</i></label>
								<input type="text" name="current_budget_officer_designation" value="{{ old('current_budget_officer_designation', $contract->current_budget_officer_designation) }}" id="current_budget_officer_designation" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-3">
								<label for="current_accountant_name">Current Accountant Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('current_accountant_name') }}</i></label>
								<input type="text" name="current_accountant_name" value="{{ old('current_accountant_name', $contract->current_accountant_name) }}" id="current_accountant_name" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-3">
								<label for="current_accountant_designation">Current Accountant Designation <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. Accountant III</i> <i class="text-danger font-weight-bold">{{ $errors->first('current_accountant_designation') }}</i></label>
								<input type="text" name="current_accountant_designation" value="{{ old('current_accountant_designation', $contract->current_accountant_designation) }}" id="current_accountant_designation" class="form-control form-control-sm" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label for="agency_head_id_name">Agency Head Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('agency_head_id_name') }}</i></label>
								<input type="text" name="agency_head_id_name" value="{{ old('agency_head_id_name', $contract->agency_head_id_name) }}" id="agency_head_id_name" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-4">
								<label for="agency_head_id_number">Government Issued ID <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('agency_head_id_number') }}</i></label>
								<input type="text" name="agency_head_id_number" value="{{ old('agency_head_id_number', $contract->agency_head_id_number) }}" id="agency_head_id_number" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-4">
								<label for="agency_head_id_date_issued">Date Issued <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. May 2020, LTO Santa Rosa</i> <i class="text-danger font-weight-bold">{{ $errors->first('agency_head_id_date_issued') }}</i></label>
								<input type="text" name="agency_head_id_date_issued" value="{{ old('agency_head_id_date_issued', $contract->agency_head_id_date_issued) }}" id="agency_head_id_date_issued" class="form-control form-control-sm" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label for="second_party_id_name">Second Party Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('second_party_id_name') }}</i></label>
								<input type="text" name="second_party_id_name" value="{{ old('second_party_id_name', $contract->second_party_id_name) }}" id="second_party_id_name" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-4">
								<label for="second_party_id_number">Government Issued ID <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('second_party_id_number') }}</i></label>
								<input type="text" name="second_party_id_number" value="{{ old('second_party_id_number', $contract->second_party_id_number) }}" id="second_party_id_number" class="form-control form-control-sm" required>
							</div>
							<div class="col-md-4">
								<label for="second_party_id_date_issued">Date Issued <span class="text-danger">*</span> <i class="text-info font-weight-bold">e.g. May 2020, LTO Santa Rosa</i> <i class="text-danger font-weight-bold">{{ $errors->first('second_party_id_date_issued') }}</i></label>
								<input type="text" name="second_party_id_date_issued" value="{{ old('second_party_id_date_issued', $contract->second_party_id_date_issued) }}" id="second_party_id_date_issued" class="form-control form-control-sm" required>
							</div>
						</div>
						<div class="form-group text-danger font-weight-bold">
							NOTE: Please use the following paper size when printing the ff:
							<li>Legal Size for Contract of Service, Job Order and Amendment</li>
							<li>A4 for Statement of Actual Duties and Responsibilities</li>
						</div>
						<div class="form-group mb-1">
                        	<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
                            <a href="{{ route('Job Contract') }}" class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
                        </div>
					</div>
				</div>
			</div>
		</div>
	@endsection
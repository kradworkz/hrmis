@extends('layouts.content')
    @section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('hr.employees.pds.nav')
                    <div class="card-body">
                    	<form action="{{ route('Submit Family Background', ['employee_id' => $employee->id]) }}" method="POST" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="card">
                            	<h6 class="card-header bg-secondary text-white rounded-0">
                                    <div class="d-flex align-items-center">
                                        <small class="float-left mx-auto w-100">Family Background</small>
                                    </div>
                                </h6>
                            	<div class="card-body">
                            		<input type="integer" min="1" name="employee_id" value="{{ $employee->id }}" hidden>
                            		<div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="spouse_last_name">Spouse's Last Name</label>
                                            <input type="text" name="spouse_last_name" value="{{ old('spouse_last_name', $family_background->spouse_last_name) }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="spouse_middle_name">Middle Name </label>
                                            <input type="text" name="spouse_middle_name" value="{{ old('spouse_middle_name', $family_background->spouse_middle_name) }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="spouse_first_name">First Name</label>
                                            <input type="text" name="spouse_first_name" value="{{ old('spouse_first_name', $family_background->spouse_first_name) }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="spouse_name_extension">Name Extension</label>
                                            <input type="text" name="spouse_name_extension" value="{{ old('spouse_name_extension', $family_background->spouse_name_extension) }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="spouse_occupation">Occupation</label>
                                            <input type="text" name="spouse_occupation" value="{{ old('spouse_occupation', $family_background->spouse_occupation) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-3">
                                            <label for="business_name">Employer/Business Name</label>
                                            <input type="text" name="business_name" value="{{ old('business_name', $family_background->business_name) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-3">
                                            <label for="business_address">Business Address</label>
                                            <input type="text" name="business_address" value="{{ old('business_address', $family_background->business_address) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-3">
                                            <label for="business_telephone">Telephone Number</label>
                                            <input type="text" name="business_telephone" value="{{ old('business_telephone', $family_background->business_telephone) }}" class="form-control form-control-sm">  
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="father_last_name">Father's Last Name</label>
                                            <input type="text" name="father_last_name" value="{{ old('father_last_name', $family_background->father_last_name) }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="father_middle_name">Middle Name </label>
                                            <input type="text" name="father_middle_name" value="{{ old('father_middle_name', $family_background->father_middle_name) }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="father_first_name">First Name</label>
                                            <input type="text" name="father_first_name" value="{{ old('father_first_name', $family_background->father_first_name) }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="father_name_extension">Name Extension</label>
                                            <input type="text" name="father_name_extension" value="{{ old('father_name_extension', $family_background->father_name_extension) }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="mother_last_name">Mother's Last Name</label>
                                            <input type="text" name="mother_last_name" value="{{ old('mother_last_name', $family_background->mother_last_name) }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="mother_middle_name">Middle Name </label>
                                            <input type="text" name="mother_middle_name" value="{{ old('mother_middle_name', $family_background->mother_middle_name) }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="mother_first_name">First Name</label>
                                            <input type="text" name="mother_first_name" value="{{ old('mother_first_name', $family_background->mother_first_name) }}" class="form-control form-control-sm">
                                        </div>
                                        
                                    </div>
                                    <table class="table table-hover table-bordered mt-4 mb-0">
	                            		<thead>
	                            			<tr>
	                            				<th>Name of Children</th>
	                            				<th>Date of Birth</th>
	                            				<th class="text-right"><a href="#" class="badge badge-primary rounded-0" data-toggle="modal" id="newChild" data-target="#childrenModal" data-url="{{ route('New Child', ['id' => 0, 'employee_id' => $employee->id]) }}">ADD</a></th>
	                            			</tr>
	                            		</thead>
                                        @if(count($children))
	                            		<tbody>
                                            @foreach($children as $child)
    	                            			<tr class="clickable-row" data-toggle="modal" data-target="#childrenModal" data-url="{{ route('Edit Child', ['id' => $child->id, 'employee_id' => $employee->id]) }}">
    	                            				<td>{!! $child->full_name !!}</td>
    	                            				<td colspan="2">{!! $child->date_of_birth->format('F d, Y') !!}</td>
    	                            			</tr>
                                            @endforeach
	                            		</tbody>
                                        @endif
	                            	</table>
	                            	<div class="form-group mt-3 mb-0">
	                                    <input type="submit" name="Save" class="btn btn-primary btn-sm btn-block">
	                                </div>	
                            	</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		<div class="modal fade" id="childrenModal" tabindex="-1" role="dialog" aria-labelledby="childrenModal" aria-hidden="true">
		    <div class="modal-dialog modal-dialog-centered modal-md">
		        <div class="modal-content rounded-0">
		            <div class="card-header">
		                <div class="d-flex align-items-center">
		                    <span class="float-left mx-auto w-100">Child Information</span>
		                </div>
		            </div>
		            <div class="modal-body">
		                <div id="formContainer"></div>
		            </div>
		        </div>
		    </div>
		</div>
    @endsection
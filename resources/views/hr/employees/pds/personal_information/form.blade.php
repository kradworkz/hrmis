@extends('layouts.content')
    @section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('hr.employees.pds.nav')
                    <div class="card-body">
                        <form action="{{ route('Submit Personal Information', ['employee_id' => $employee->id]) }}" method="POST" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="card">
                                <h6 class="card-header bg-secondary text-white rounded-0">
                                    <div class="d-flex align-items-center">
                                        <small class="float-left mx-auto w-100">Personal Information</small>
                                    </div>
                                </h6>
                                <div class="card-body">
                                    <input type="integer" min="1" name="employee_id" value="{{ $employee->id }}" hidden>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="first_name">First Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('first_name') }}</i></label>
                                            <input type="text" name="first_name" value="{{ old('first_name', $personal_info->first_name) }}" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="middle_name">Middle Name </label>
                                            <input type="text" name="middle_name" value="{{ old('middle_name', $personal_info->middle_name) }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="last_name">Last Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('last_name') }}</i></label>
                                            <input type="text" name="last_name" value="{{ old('last_name', $personal_info->last_name) }}" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="name_extension">Name Extension</label>
                                            <input type="text" name="name_extension" value="{{ old('name_extension', $personal_info->name_extension) }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="birthday">Date of Birth <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('birthday') }}</i></label>
                                            <input type="text" name="birthday" value="{{ old('birthday', $personal_info->date_of_birth) }}" class="form-control form-control-sm" id="pdsDate" required>  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="place_of_birth">Place of Birth <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('place_of_birth') }}</i></label>
                                            <input type="text" name="place_of_birth" value="{{ old('place_of_birth', $personal_info->place_of_birth) }}" class="form-control form-control-sm" required>  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="citizenship">Citizenship: <strong class="text-danger">*</strong></label>
                                            <select name="citizenship" class="form-control form-control-sm">
                                                <option value="Filipino" {{ old('citizenship', $personal_info->citizenship) == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                                                <option value="Dual Citizenship" {{ old('citizenship', $personal_info->citizenship) == 'Dual Citizenship' ? 'selected' : '' }}>Dual Citizenship</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="gender">Sex: <strong class="text-danger">*</strong></label>
                                            <select name="gender" class="form-control form-control-sm">
                                                <option value="Male" {{ old('gender', $personal_info->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender', $personal_info->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="civil_status">Civil Status: <strong class="text-danger">*</strong></label>
                                            <select name="civil_status" class="form-control form-control-sm">
                                                <option value="Single" {{ old('civil_status', $personal_info->civil_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                                <option value="Married" {{ old('civil_status', $personal_info->civil_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                                <option value="Widowed" {{ old('civil_status', $personal_info->civil_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                                <option value="Separated" {{ old('civil_status', $personal_info->civil_status) == 'Separated' ? 'selected' : '' }}>Separated</option>
                                                <option value="Other/s" {{ old('civil_status', $personal_info->civil_status) == 'Other/s' ? 'selected' : '' }}>Other/s</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="height">Height (cm)</label>
                                            <input type="number" name="height" step=".01" value="{{ old('height', $personal_info->height) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-2">
                                            <label for="weight">Weight (kg)</label>
                                            <input type="number" name="weight" step=".01" value="{{ old('weight', $personal_info->weight) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-2">
                                            <label for="blood_type">Blood Type</label>
                                            <input type="text" name="blood_type" value="{{ old('blood_type', $personal_info->blood_type) }}" class="form-control form-control-sm">  
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="gsis_id">GSIS:</label>
                                            <input type="text" name="gsis_id" value="{{ old('gsis_id', $personal_info->gsis_id) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pagibig_id">PAGIBIG:</label>
                                            <input type="text" name="pagibig_id" value="{{ old('pagibig_id', $personal_info->pagibig_id) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="philhealth_id">PHILHEALTH:</label>
                                            <input type="text" name="philhealth_id" value="{{ old('philhealth_id', $personal_info->philhealth_id) }}" class="form-control form-control-sm">  
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="sss_id">SSS:</label>
                                            <input type="text" name="sss_id" value="{{ old('sss_id', $personal_info->sss_id) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="tin_id">TIN:</label>
                                            <input type="text" name="tin_id" value="{{ old('tin_id', $personal_info->tin_id) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="agency_employee_number">AGENCY EMPLOYEE NO:</label>
                                            <input type="text" name="agency_employee_number" value="{{ old('agency_employee_number', $personal_info->agency_employee_number) }}" class="form-control form-control-sm">  
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="telephone_number">Telephone Number:</label>
                                            <input type="number" min="0" name="telephone_number" value="{{ old('telephone_number', $personal_info->telephone_number) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="mobile_number">Mobile Number:</label>
                                            <input type="number" min="0" name="mobile_number" value="{{ old('mobile_number', $personal_info->mobile_number) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="email">Email:</label>
                                            <input type="email" name="email" value="{{ old('email', $personal_info->email) }}" class="form-control form-control-sm">  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <h6 class="card-header bg-secondary text-white rounded-0"><small>Residential Address</small></h6>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="residential_house_info">House/Block/Lot No:</label>
                                            <input type="text" name="residential_house_info" value="{{ old('residential_house_info', $personal_info->residential_house_info) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-3">
                                            <label for="residential_street">Street:</label>
                                            <input type="text" name="residential_street" value="{{ old('residential_street', $personal_info->residential_street) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-3">
                                            <label for="residential_subdivision">Subdivision/Village:</label>
                                            <input type="text" name="residential_subdivision" value="{{ old('residential_subdivision', $personal_info->residential_subdivision) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-3">
                                            <label for="residential_barangay">Barangay:</label>
                                            <input type="text" name="residential_barangay" value="{{ old('residential_barangay', $personal_info->residential_barangay) }}" class="form-control form-control-sm">  
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="residential_city">City:</label>
                                            <input type="text" name="residential_city" value="{{ old('residential_city', $personal_info->residential_city) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="residential_province">Province:</label>
                                            <input type="text" name="residential_province" value="{{ old('residential_province', $personal_info->residential_province) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="residential_zip_code">Zip Code:</label>
                                            <input type="number" min="0" name="residential_zip_code" value="{{ old('residential_zip_code', $personal_info->residential_zip_code) }}" class="form-control form-control-sm">  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-header bg-secondary text-white rounded-0">Permanent Address</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label for="permanent_house_info">House/Block/Lot No:</label>
                                            <input type="text" name="permanent_house_info" value="{{ old('permanent_house_info', $personal_info->permanent_house_info) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-3">
                                            <label for="permanent_street">Street:</label>
                                            <input type="text" name="permanent_street" value="{{ old('permanent_street', $personal_info->permanent_street) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-3">
                                            <label for="permanent_subdivision">Subdivision/Village:</label>
                                            <input type="text" name="permanent_subdivision" value="{{ old('permanent_subdivision', $personal_info->permanent_subdivision) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-3">
                                            <label for="permanent_barangay">Barangay:</label>
                                            <input type="text" name="permanent_barangay" value="{{ old('permanent_barangay', $personal_info->permanent_barangay) }}" class="form-control form-control-sm">  
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="permanent_city">City:</label>
                                            <input type="text" name="permanent_city" value="{{ old('permanent_city', $personal_info->permanent_city) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="permanent_province">Province:</label>
                                            <input type="text" name="permanent_province" value="{{ old('permanent_province', $personal_info->permanent_province) }}" class="form-control form-control-sm">  
                                        </div>
                                        <div class="col-md-4">
                                            <label for="permanent_zip_code">Zip Code:</label>
                                            <input type="number" min="0" name="permanent_zip_code" value="{{ old('permanent_zip_code', $personal_info->permanent_zip_code) }}" class="form-control form-control-sm">  
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" name="Save" class="btn btn-primary btn-sm btn-block">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
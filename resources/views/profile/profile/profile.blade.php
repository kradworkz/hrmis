@extends('layouts.content')
    @section('content')
    	@include('profile.cards.cards')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    @include('profile.nav')
                    <div class="card-body">
                        <div class="card">
                        	<h6 class="card-header bg-secondary text-white rounded-0">
                        		<div class="d-flex align-items-center">
                        			<small class="float-left mx-auto w-100">Account Information</small>
                        		</div>
                        	</h6>
                        	<div class="card-body">
                        		<form action="{{ route('Submit Profile') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
									{{ csrf_field() }}

	                        		<?php
									$logo = '/public/images/dost24.png';
									// $qr = hrmis\Models\QrCode::where('e_id', $employee->id)
									// ->orderBy('id', 'ASC')
									// ->first();
									?>


										<!-- @if (!$qr)
											<a class="btn btn-lg btn-primary my-2" href="{{ route('Profile Enroll', ['id' => $employee->id]) }}" title="Enroll QR Code">Enroll QR Code</a>
										@else
											<div class="d-inline-block m-4 p-1 text-center">
												<img src="data:image/png;base64, {!! base64_encode(QrCode::errorCorrection('H')->format('png')->merge($logo)->size(200)->generate($employee->full_name.' DOST4A')) !!} ">
												<div>
													<a class="btn btn-sm btn-primary my-2" href="{{ route('Profile Enroll', ['id' => $employee->id]) }}" title="Refresh QR Code">Refesh QR Code</a>
												</div>
											</div>
										@endif -->

									<div class="form-group row">
										<div class="col-md-4">
											<label for="first_name">First Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('first_name') }}</i></label>
											<input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" id="first_name" class="form-control form-control-sm">
										</div>
										<div class="col-md-4">
											<label for="middle_name">Middle Name <i class="text-danger font-weight-bold">{{ $errors->first('middle_name') }}</i></label>
											<input type="text" name="middle_name" value="{{ old('middle_name', $employee->middle_name) }}" id="middle_name" class="form-control form-control-sm">
										</div>
										<div class="col-md-4">
											<label for="last_name">Last Name <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('last_name') }}</i></label>
											<input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" id="last_name" class="form-control form-control-sm">
										</div>
									</div>
									<div class="form-group">
										<label for="email">Email Address </label>
										<input type="text" name="email" value="{{ old('email', $employee->email) }}" id="email" class="form-control form-control-sm">
									</div>
									<div class="form-group">
										<label for="password">Password <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('password') }}</i></label>
										<input type="password" name="password" id="password" class="form-control form-control-sm">
									</div>
									<div class="form-group">
										<label for="password_confirmation">Confirm Password <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('password_confirmation') }}</i></label>
										<input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-sm">
									</div>
									<div class="form-group row">
										<div class="col-md-6">
											<label for="picture">Profile Picture <i class="text-danger font-weight-bold">{{ $errors->first('picture') }}</i></label>
											<input type="file" name="picture" multiple class="form-control-file">
										</div>
									</div>
									<div class="form-group mb-0">
                                        <input type="submit" name="Save" class="btn btn-primary btn-sm btn-block">
                                    </div>
								</form>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
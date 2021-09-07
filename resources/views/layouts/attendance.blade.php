@if(!Auth::user()->health_declaration)
    <button class="d-inline-block btn btn-primary btn-sm text-nowrap mt-2 rounded-0 font-weight-bold timeInBtn" data-toggle="modal" data-target="#healthCheckDeclarationForm">Health Declaration</button>
@else
    @if(Auth::user()->time_in)
        <h3 class="d-inline-block hrmis-date text-nowrap">Time In: {!! optional(\Auth::user()->time_in->time_in)->format('h:i A') !!}&nbsp</h3>
        @if(Auth::user()->time_out == null)
            <a href="{{ route('Dashboard Time Out', ['id' => Auth::id()]) }}" class="d-inline-block mb-2 btn btn-primary btn-sm text-nowrap rounded-0 font-weight-bold text-white timeInBtn">Time Out</a>
        @else
            <h3 class="d-inline-block hrmis-date text-nowrap">/ Time Out: {!! optional(\Auth::user()->time_out->time_out)->format('h:i A') !!}</h3>
        @endif
    @else
        <form action="{{ route('Desktop Time In', ['id' => Auth::id(), 'location' => Auth::user()->health_declaration ? Auth::user()->health_declaration->attendance_location : 1]) }}">
            {{ csrf_field() }}
            <button type="submit" class="d-inline-block btn btn-primary btn-sm text-nowrap mt-2 rounded-0 font-weight-bold timeInBtn">Time In</button>
        </form>
    @endif
@endif
<div class="modal fade" id="healthCheckDeclarationForm" tabindex="-1" role="dialog" aria-labelledby="healthCheckDeclarationForm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">Health Check Declaration Form</div>
            <div class="modal-body text-left">
                <form action="{{ route('Submit Health Check', ['id' => Auth::id()]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="full_name">Full Name</label>
                            <input type="text" name="full_name" class="form-control form-control-sm" value="{{ Auth::user()->full_name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="temperature">Temperature Check</label>
                            <input type="number" name="temperature" id="temperature" min="0" step=".01" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-10">
                            <label>1. Are you experiencing any of the following? (Nakararanas ka ba ng alinman sa sumusunod?)</label>
                        </div>
                        <div class="col-md-2">
                            <!-- <a href="#" id="yes" class="badge badge-danger">Yes to All</a>  -->
                            <a href="#" id="no" class="badge badge-success float-right mr-3">No to All</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8 offset-md-1">
                            <label>a. Fever for the past few days (Lagpas sa nakalipas na mga araw)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="fever" id="fever" value="Fever" required>
                                <label class="form-check-label" for="fever">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="fever" id="no_fever" value="" required>
                                <label class="form-check-label" for="no_fever">No</label>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-1">
                            <label>b. Dry Cough (Tuyong Ubo)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="cough" id="cough" value="Cough" required>
                                <label class="form-check-label" for="cough">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="cough" id="no_cough" value="" required>
                                <label class="form-check-label" for="no_cough">No</label>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-1">
                            <label>c. Fatigue (Pagkapagod)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox yes_class" type="radio" name="fatigue" id="fatigue" value="Fatigue" required>
                                <label class="form-check-label" for="fatigue">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="fatigue" id="no_fatigue" value="" required>
                                <label class="form-check-label" for="no_fatigue">No</label>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-1">
                            <label>d. Aches and Pains (Pananakit ng katawan)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="ache" id="ache" value="Ache" required>
                                <label class="form-check-label" for="ache">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="ache" id="no_ache" value="" required>
                                <label class="form-check-label" for="no_ache">No</label>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-1">
                            <label>e. Runny Nose (Sipon)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="runny_nose" id="runny_nose" value="Runny Nose" required>
                                <label class="form-check-label" for="runny_nose">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="runny_nose" id="no_runny_nose" value="" required>
                                <label class="form-check-label" for="no_runny_nose">No</label>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-1">
                            <label>f. Shortness of Breath (Hirap sa paghinga)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="shortness_of_breath" id="shortness_of_breath" value="Shortness of Breath" required>
                                <label class="form-check-label" for="shortness_of_breath">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="shortness_of_breath" id="no_shortness_of_breath" value="" required>
                                <label class="form-check-label" for="no_shortness_of_breath">No</label>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-1">
                            <label>g. Diarrhea (Pagtatae)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="diarrhea" id="diarrhea" value="Diarrhea" required>
                                <label class="form-check-label" for="diarrhea">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="diarrhea" id="no_diarrhea" value="" required>
                                <label class="form-check-label" for="no_diarrhea">No</label>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-1">
                            <label>h. Headache (Pananakit ng ulo)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox yes_class" type="radio" name="headache" id="headache" value="Headache" required>
                                <label class="form-check-label" for="headache">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="headache" id="no_headache" value="" required>
                                <label class="form-check-label" for="no_headache">No</label>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-1">
                            <label>i. Sore Throat (Pananakit o pamamaga ng lalamunan)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="sore_throat" id="sore_throat" value="Sore Throat" required>
                                <label class="form-check-label" for="sore_throat">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="sore_throat" id="no_sore_throat" value="" required>
                                <label class="form-check-label" for="no_sore_throat">No</label>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-1">
                            <label>j. Loss of Taste or Smell (Nawalan ng panlasa o pang-amoy)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="loss_of_taste" id="loss_of_taste" value="Loss of Taste or Smell" required>
                                <label class="form-check-label" for="loss_of_taste">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="loss_of_taste" id="no_lost_of_taste" value="" required>
                                <label class="form-check-label" for="no_lost_of_taste">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9">  
                            <label>2. Have you worked together or stayed in the same close environment of a confined COVID-19 case? (May nakasama ka ba o nakatrabahong tao na kumpirmadong may COVID-19/may impeksyon ng corona virus?)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="q2" id="q2" value="q2" required>
                                <label class="form-check-label" for="q2">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="q2" id="no_q2" value="" required>
                                <label class="form-check-label" for="no_q2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9">  
                            <label>3. Have you had any contact with anyone with fever, cough, colds and sore throat in the past 2 weeks? (Mayroon ka bang nakasamang may lagnat, ubo, sipon o sakit ng lalamunan sa nakalipas na dalawang linggo?)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox yes_class" type="radio" name="q3" id="q3" value="q3" required>
                                <label class="form-check-label" for="q3">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="q3" id="no_q3" value="" required>
                                <label class="form-check-label" for="no_q3">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9">  
                            <label>4. Have you travelled outside the Philippines in the last 14 days? (Ikaw ba ay nagbyahe sa labas ng Pilipinas sa nakalipas na 14 na araw?)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="q4" id="q4" value="q4" required>
                                <label class="form-check-label" for="q4">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="q4" id="no_q4" value="" required>
                                <label class="form-check-label" for="no_q4">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9">  
                            <label>5. Have you travelled to any area in NCR aside from your home? (Ikaw ba ay nagpunta sa iba pang parte ng NCR or Metro Manila bukod sa iyong bahay?)</label>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox yes_class" type="radio" name="q5" id="q5" value="q5" required>
                                <label class="form-check-label" for="q5">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox no_class" type="radio" name="q5" id="no_q5" value="" required>
                                <label class="form-check-label" for="no_q5">No</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Specify (Sabihin kung saan):</label>
                            <input type="text" name="location" value="" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <div class="col-md-9">
                            <label>6. Select Work Location</label>
                        </div>
                        <div class="col-md-3 text-right">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox work_location" name="work_location" type="radio" id="home" value="0" required>
                                <label class="form-check-label font-weight-bold text-primary" for="home"><i class="fa fa-home"></i> Home</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox work_location" name="work_location" type="radio" id="office" value="1" required>
                                <label class="form-check-label font-weight-bold text-success" for="office"><i class="fa fa-building"></i> Office</label>
                            </div>
                            <input type="hidden" name="attendance_location" id="attendance_location" value="">
                        </div>
                    </div>
                    <div class="form-group row mb-1 d-none" id="mode_of_conveyance">
                        <div class="col-md-3">
                            <label>7. Mode of Conveyance</label>
                        </div>
                        <div class="col-md-9 text-right">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox mode_of_conveyance" name="mode_of_conveyance" type="radio" id="office_vehicle" value="Office Vehicle" {{ Auth::user()->checkVehicle ? 'checked' : '' }}>
                                <label class="form-check-label font-weight-bold text-primary" for="office_vehicle"> Office Vehicle</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox mode_of_conveyance" name="mode_of_conveyance" type="radio" id="public_conveyance" value="Public Conveyance">
                                <label class="form-check-label font-weight-bold text-danger" for="public_conveyance"> Public Conveyance</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox mode_of_conveyance" name="mode_of_conveyance" type="radio" id="private_vehicle" value="Private Vehicle">
                                <label class="form-check-label font-weight-bold text-info" for="private_vehicle"><i class="fa fa-building"></i> Private Vehicle</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input big-checkbox mode_of_conveyance" name="mode_of_conveyance" type="radio" id="carpool" value="Carpool">
                                <label class="form-check-label font-weight-bold text-warning" for="carpool"><i class="fa fa-building"></i> Carpool</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row d-none" id="vehicle_plate_number">
                        <div class="col-md-12">
                            <label>Plate Number</label>
                            <input type="text" name="remarks" id="remarks" value="{{ Auth::user()->checkVehicle ? Auth::user()->checkVehicle->reservation->vehicle->plate_number : '' }}" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group mb-0 d-none" id="memo">
                        <p class="font-weight-bold"><i class="text-danger">Health Group Advisory: Hold reporting to the office, stay home and wait for further advise. Inform your immediate supervisor and driver if you are travelling using office vehicle.</i></p>
                    </div>
                     <div class="form-group">
                        <p class="text-justify">I hereby authorize the Department of Science and Technology to collect and process the data indicated herein for the purpose of effecting the control of COVID-19 infection.
                        I understand that the my personal information is protected by RA 10173, Data Privacy Act of 2012, and I am required by RA 11469, Bayanihan to Heal as One Act, to provide truthful information.</p>
                    </div>
                    <div class="form-group mb-0">
                        <input type="submit" id="submit-btn" class="btn btn-primary btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">Work Location</div>
            <div class="modal-body text-left">
                <a href="{{ route('Desktop Time In', ['id' => Auth::id(), 'location' => Auth::user()->health_declaration ? Auth::user()->health_declaration->attendance_location : 1]) }}" class="btn btn-block btn-primary rounded-0"><i class="fa fa-home fa-fw"></i> Home</a>
            </div>
        </div>
    </div>
</div>

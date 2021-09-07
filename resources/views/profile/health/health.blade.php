@extends('layouts.content')
    @section('content')
    	@include('profile.cards.cards')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    @include('profile.nav')
                    <div class="card-body">
                    	<div class="d-flex align-items-center">
                            <form action="{{ route($route, ['id' => isset($id) ? $id : null]) }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Date</span>
                                    </div>
                                    <input type="date" name="date" class="form-control form-control-sm" value="{{ old('date', $date) }}" min="1950-01-01" max="{{ date('Y-m-d') }}">
                                </div>
                                <div class="input-group input-group-sm ml-2">
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                    @if($health)
                                        <a href="#" data-toggle="modal" data-target="#healthModal" class="btn btn-info btn-sm rounded-0 ml-2">Edit</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    @if($health)
                        <div class="table-responsive">
                            <table class="table table-hover pb-0 mb-0">
                                <tr>
                                    <td width="70%">1. Temperature</td>
                                    <td class="text-left">{!! $health->temperature !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">2. Fever for the past few days (Lagpas sa nakalipas na mga araw)</td>
                                    <td class="text-left">{!! $health->fever != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">3. Dry Cough (Tuyong Ubo)</td>
                                    <td class="text-left">{!! $health->cough != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">4. Fatigue (Pagkapagod)</td>
                                    <td class="text-left">{!! $health->fatigue != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">5. Aches and Pains (Pananakit ng katawan)</td>
                                    <td class="text-left">{!! $health->ache != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">6. Runny Nose (Sipon)</td>
                                    <td class="text-left">{!! $health->runny_nose != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">7. Shortness of Breath (Hirap sa paghinga)</td>
                                    <td class="text-left">{!! $health->shortness_of_breath != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">8. Diarrhea (Pagtatae)</td>
                                    <td class="text-left">{!! $health->diarrhea != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">9. Headache (Pananakit ng ulo)</td>
                                    <td class="text-left">{!! $health->headache != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">10. Sore Throat (Pananakit o pamamaga ng lalamunan)</td>
                                    <td class="text-left">{!! $health->sore_throat != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">11. Loss of Taste or Smell (Nawalan ng panlasa o pang-amoy)</td>
                                    <td class="text-left">{!! $health->loss_of_taste != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">12. Have you worked together or stayed in the same close environment of a confined COVID-19 case? (May nakasama ka ba o nakatrabahong tao na kumpirmadong may COVID-19/may impeksyon ng corona virus?)</td>
                                    <td class="text-left">{!! $health->q2 != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">13. Have you had any contact with anyone with fever, cough, colds and sore throat in the past 2 weeks? (Mayroon ka bang nakasamang may lagnat, ubo, sipon o sakit ng lalamunan sa nakalipas na dalawang linggo?)</td>
                                    <td class="text-left">{!! $health->q3 != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">14. Have you travelled outside the Philippines in the last 14 days? (Ikaw ba ay nagbyahe sa labas ng Pilipinas sa nakalipas na 14 na araw?)</td>
                                    <td class="text-left">{!! $health->q4 != null ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                </tr>
                                <tr>
                                    <td width="70%">15. Have you travelled to any area in NCR aside from your home? (Ikaw ba ay nagpunta sa iba pang parte ng NCR or Metro Manila bukod sa iyong bahay?)</td>
                                    <td class="text-left">{!! $health->location !!}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal fade" id="healthModal" tabindex="-1" role="dialog" aria-labelledby="healthModal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">Health Check Declaration Form</div>
                                    <div class="modal-body text-left">
                                        <form action="{{ route('Update Health Declaration Form', ['id' => $health->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="temperature">Temperature Check</label>
                                                <input type="number" name="temperature" id="temperature" min="0" step=".01" value="{{ old('temperature', $health->temperature) }}" class="form-control form-control-sm">
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-11">
                                                    <label>1. Are you experiencing any of the following? (Nakararanas ka ba ng alinman sa sumusunod?)</label>
                                                </div>
                                                <div class="col-md-8 offset-md-1">
                                                    <label>a. Fever for the past few days (Lagpas sa nakalipas na mga araw)</label>
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox is_risky" type="radio" name="fever" id="fever" value="Fever" {{ $health->fever != null ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="fever">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="fever" id="no_fever" value="" {{ $health->fever == "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="no_fever">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 offset-md-1">
                                                    <label>b. Dry Cough (Tuyong Ubo)</label>
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox is_risky" type="radio" name="cough" id="cough" value="Cough" {{ $health->cough != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="cough">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="cough" id="no_cough" value="" {{ $health->cough == "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="no_cough">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 offset-md-1">
                                                    <label>c. Fatigue (Pagkapagod)</label>
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="fatigue" id="fatigue" value="Fatigue" {{ $health->fatigue != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="fatigue">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="fatigue" id="no_fatigue" value="" {{ $health->fatigue == "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="no_fatigue">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 offset-md-1">
                                                    <label>d. Aches and Pains (Pananakit ng katawan)</label>
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox is_risky" type="radio" name="ache" id="ache" value="Ache" {{ $health->ache != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="ache">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="ache" id="no_ache" value="" {{ $health->ache == "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="no_ache">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 offset-md-1">
                                                    <label>e. Runny Nose (Sipon)</label>
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox is_risky" type="radio" name="runny_nose" id="runny_nose" value="Runny Nose" {{ $health->runny_nose != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="runny_nose">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="runny_nose" id="no_runny_nose" value="" {{ $health->runny_nose == "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="no_runny_nose">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 offset-md-1">
                                                    <label>f. Shortness of Breath (Hirap sa paghinga)</label>
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox is_risky" type="radio" name="shortness_of_breath" id="shortness_of_breath" value="Shortness of Breath" {{ $health->shortness_of_breath != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="shortness_of_breath">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="shortness_of_breath" id="no_shortness_of_breath" value="" {{ $health->shortness_of_breath == "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="no_shortness_of_breath">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 offset-md-1">
                                                    <label>g. Diarrhea (Pagtatae)</label>
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox is_risky" type="radio" name="diarrhea" id="diarrhea" value="Diarrhea" {{ $health->diarrhea != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="diarrhea">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="diarrhea" id="no_diarrhea" value="" {{ $health->diarrhea == "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="no_diarrhea">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 offset-md-1">
                                                    <label>h. Headache (Pananakit ng ulo)</label>
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox yes_class" type="radio" name="headache" id="headache" value="Headache" {{ $health->headache != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="headache">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox no_class" type="radio" name="headache" id="no_headache" value="" {{ $health->headache == "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="no_headache">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 offset-md-1">
                                                    <label>i. Sore Throat (Pananakit o pamamaga ng lalamunan)</label>
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="sore_throat" id="sore_throat" value="Sore Throat" {{ $health->sore_throat != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="sore_throat">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox no_class" type="radio" name="sore_throat" id="no_sore_throat" value="" {{ $health->sore_throat == "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="no_sore_throat">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 offset-md-1">
                                                    <label>j. Loss of Taste or Smell (Nawalan ng panlasa o pang-amoy)</label>
                                                </div>
                                                <div class="col-md-2 offset-md-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox is_risky yes_class" type="radio" name="loss_of_taste" id="loss_of_taste" value="Loss of Taste or Smell" {{ $health->loss_of_taste != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="loss_of_taste">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox no_class" type="radio" name="loss_of_taste" id="no_lost_of_taste" value="" {{ $health->loss_of_taste == "" ? 'checked' : '' }} required>
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
                                                        <input class="form-check-input big-checkbox is_risky" type="radio" name="q2" id="q2" value="q2" {{ $health->q2 != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="q2">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="q2" id="no_q2" value="" {{ $health->q2 == "" ? 'checked' : '' }} required>
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
                                                        <input class="form-check-input big-checkbox" type="radio" name="q3" id="q3" value="q3" {{ $health->q3 != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="q3">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="q3" id="no_q3" value="" {{ $health->q3 == "" ? 'checked' : '' }} required>
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
                                                        <input class="form-check-input big-checkbox is_risky" type="radio" name="q4" id="q4" value="q4" {{ $health->q4 != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="q4">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="q4" id="no_q4" value="" {{ $health->q4 == "" ? 'checked' : '' }} required>
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
                                                        <input class="form-check-input big-checkbox" type="radio" name="q5" id="q5" value="q5" {{ $health->q5 != "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="q5">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input big-checkbox" type="radio" name="q5" id="no_q5" value="" {{ $health->q5 == "" ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="no_q5">No</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Specify (Sabihin kung saan):</label>
                                                    <input type="text" name="location" value="{{ old('location', $health->location) }}" class="form-control form-control-sm">
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
                    @endif
                </div>
            </div>
        </div>
        
    @endsection

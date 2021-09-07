@extends('layouts.content')
    @section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('hr.employees.pds.nav')
                    <div class="card-body">
                    	<div class="card">
                            <h6 class="card-header bg-secondary text-white rounded-0">
                                <div class="d-flex align-items-center">
                                    <small class="float-left mx-auto w-100">Civil Service Eligibility</small>
                                    <a href="#" class="badge badge-primary rounded-0 custom-badge text-white" id="newBtn" data-toggle="modal" data-target="#formModal" data-url="{{ route('New Civil Service Eligibility', ['id' => 0, 'employee_id' => $employee->id]) }}"><small>NEW</small></a>
                                </div>
                            </h6>
                            <div class="card-body">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="align-middle text-center" width="30%" rowspan="2">Career Service/RA 1080 (Board/Bar) Under Special Laws/CES/CSEE Barangay Eligibility/Driver's License</th>
                                            <th class="align-middle text-center" rowspan="2">Rating (If Applicable)</th>
                                            <th class="align-middle text-center" rowspan="2">Date of Examination/Conferment</th>
                                            <th class="align-middle text-center" rowspan="2">Place of Examination/Conferment</th>
                                            <th class="align-middle text-center" colspan="2">License (If Applicable)</th>
                                        </tr>
                                        <tr>
                                            <th class="align-middle text-center">Number</th>
                                            <th class="align-middle text-center">Date of Validity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($eligibility))
                                            @foreach($eligibility as $csc)
                                                <tr class="clickable-row" data-toggle="modal" data-target="#formModal" data-url="{{ route('Edit Civil Service Eligibility', ['id' => $csc->id, 'employee_id' => $employee->id]) }}">
                                                    <td class="text-center">{!! $csc->eligibility_name !!}</td>
                                                    <td class="text-center">{!! $csc->rating !!}</td>
                                                    <td class="text-center">{!! optional($csc->date_of_examination)->format('F d, Y') !!}</td>
                                                    <td class="text-center">{!! $csc->place_of_examination !!}</td>
                                                    <td class="text-center">{!! $csc->eligibility_number !!}</td>
                                                    <td class="text-center">{!! $csc->date_of_validity !!}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
               	</div>
            </div>
        </div>
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-0">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <span class="float-left mx-auto w-100">Civil Service Eligibility</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="formContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
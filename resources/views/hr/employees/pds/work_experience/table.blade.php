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
                                    <small class="float-left mx-auto w-100">Work Experience</small>
                                    <a href="#" class="badge badge-primary rounded-0 custom-badge text-white" id="newBtn" data-toggle="modal" data-target="#formModal" data-url="{{ route('New Work Experience', ['id' => 0, 'employee_id' => $employee->id]) }}"><small>NEW</small></a>
                                </div>
                            </h6>
                            <div class="card-body">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="align-middle text-center" width="30%" colspan="2">Inclusive Dates</th>
                                            <th class="align-middle text-center" rowspan="2">Position Title</th>
                                            <th class="align-middle text-center" rowspan="2">Company</th>
                                            <th class="align-middle text-center" rowspan="2">Monthly Salary</th>
                                            <th class="align-middle text-center" rowspan="2">Salary Grade</th>
                                            <th class="align-middle text-center" rowspan="2">Status of Appointment</th>
                                            <th class="align-middle text-center" rowspan="2">Government Service</th>
                                        </tr>
                                        <tr>
                                            <th class="align-middle text-center">From</th>
                                            <th class="align-middle text-center">To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@if(count($work_exp))
                                            @foreach($work_exp as $exp)
                                                <tr class="clickable-row" data-toggle="modal" data-target="#formModal" data-url="{{ route('Edit Work Experience', ['id' => $exp->id, 'employee_id' => $employee->id]) }}">
                                                    <td class="text-center">{!! optional($exp->start_date)->format('F d, Y') !!}</td>
                                                    <td class="text-center">{!! optional($exp->end_date)->format('F d, Y') !!}</td>
                                                    <td class="text-center">{!! $exp->position_title !!}</td>
                                                    <td class="text-center">{!! $exp->company !!}</td>
                                                    <td class="text-center">{!! $exp->monthly_salary !!}</td>
                                                    <td class="text-center">{!! $exp->salary_grade !!}</td>
                                                    <td class="text-center">{!! $exp->status_of_appointment !!}</td>
                                                    <td class="text-center">{!! $exp->is_government == 1 ? 'Yes' : 'No' !!}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </tbody>
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
                            <span class="float-left mx-auto w-100">Work Experience</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="formContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
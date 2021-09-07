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
                                    <small class="float-left mx-auto w-100">Training</small>
                                    <a href="#" class="badge badge-primary rounded-0 custom-badge text-white" id="newBtn" data-toggle="modal" data-target="#formModal" data-url="{{ route('New Training', ['id' => 0, 'employee_id' => $employee->id]) }}"><small>NEW</small></a>
                                </div>
                            </h6>
                            <div class="card-body">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="align-middle text-center" width="30%" rowspan="2">Title of Learning and Development Interventions/Training Programs</th>
                                            <th class="align-middle text-center" colspan="2">Inclusive Dates of Attendance</th>
                                            <th class="align-middle text-center" rowspan="2">Number of Hours</th>
                                            <th class="align-middle text-center" rowspan="2">Type of LD</th>
                                            <th class="align-middle text-center" rowspan="2">Conducted By</th>
                                        </tr>
                                        <tr>
                                            <th class="align-middle text-center">From</th>
                                            <th class="align-middle text-center">To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@if(count($training))
                                            @foreach($training as $t)
                                                <tr class="clickable-row" data-toggle="modal" data-target="#formModal" data-url="{{ route('Edit Training', ['id' => $t->id, 'employee_id' => $employee->id]) }}">
                                                    <td class="text-center">{!! $t->title !!}</td>
                                                    <td class="text-center">{!! optional($t->start_date)->format('F d, Y') !!}</td>
                                                    <td class="text-center">{!! optional($t->end_date)->format('F d, Y') !!}</td>
                                                    <td class="text-center">{!! $t->number_of_hours !!}</td>
                                                    <td class="text-center">{!! $t->type !!}</td>
                                                    <td class="text-center">{!! $t->conducted_by !!}</td>
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
                            <span class="float-left mx-auto w-100">Training</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="formContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
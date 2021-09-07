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
                                    <small class="float-left mx-auto w-100">Other Information</small>
                                    <a href="#" class="badge badge-primary rounded-0 custom-badge text-white" id="newBtn" data-toggle="modal" data-target="#formModal" data-url="{{ route('New Other Information', ['id' => 0, 'employee_id' => $employee->id]) }}"><small>NEW</small></a>
                                </div>
                            </h6>
                            <div class="card-body">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="align-middle text-center">Special Skills and Hobbies</th>
                                            <th class="align-middle text-center">Non-academic Distinctions/Recognition</th>
                                            <th class="align-middle text-center">Membership in Association/Organization</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@if(count($other_info))
                                            @foreach($other_info as $info)
                                                <tr class="clickable-row" data-toggle="modal" data-target="#formModal" data-url="{{ route('Edit Other Information', ['id' => $info->id, 'employee_id' => $employee->id]) }}">
                                                    <td class="text-center">{!! $info->skills !!}</td>
                                                    <td class="text-center">{!! $info->recognition !!}</td>
                                                    <td class="text-center">{!! $info->organization !!}</td>
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
                            <span class="float-left mx-auto w-100">Other Information</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="formContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
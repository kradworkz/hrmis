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
                        			<small class="float-left mx-auto w-100">Educational Background</small>
                        			<a href="#" class="badge badge-primary rounded-0 custom-badge text-white" id="newBtn" data-toggle="modal" data-target="#formModal" data-url="{{ route('New Educational Background', ['id' => 0, 'employee_id' => $employee->id]) }}"><small>NEW</small></a>
                        		</div>
                        	</h6>
                        	<div class="card-body">
                        		<table class="table table-bordered table-hover mb-0">
                        			<thead>
                        				<tr>
                        					<th class="align-middle text-center" rowspan="2">Level</th>
                        					<th class="align-middle text-center" rowspan="2">Name of School</th>
                        					<th class="align-middle text-center" rowspan="2">Degree</th>
                        					<th class="align-middle text-center" colspan="2">Period of Attendance</th>
                        					<th class="align-middle text-center" rowspan="2">Highest Level/Units Earned</th>
                        					<th class="align-middle text-center" rowspan="2">Year Graduated</th>
                        					<th class="align-middle text-center" rowspan="2">Scholarship/Honors Received</th>
                        				</tr>
                        				<tr>
                        					<th class="align-middle text-center">From</th>
                        					<th class="align-middle text-center">To</th>
                        				</tr>
                        			</thead>
                        			<tbody>
                        				@if(count($educational_background))
                            				@foreach($educational_background as $background)
	                            				<tr class="clickable-row" data-toggle="modal" data-target="#formModal" data-url="{{ route('Edit Educational Background', ['id' => $background->id, 'employee_id' => $employee->id]) }}">
	                            					<td class="text-center">
                                                        @if($background->type == 0)
                                                            Elementary
                                                        @elseif($background->type == 1)
                                                            Secondary
                                                        @elseif($background->type == 2)
                                                            Vocational/Trade Course
                                                        @elseif($background->type == 3)
                                                            College
                                                        @elseif($background->type == 4)
                                                            Graduate Studies
                                                        @endif
                                                    </td>
	                            					<td class="text-center">{!! $background->name_of_school !!}</td>
	                            					<td class="text-center">{!! $background->degree !!}</td>
	                            					<td class="text-center">{!! optional($background->period_from)->format('F d, Y') !!}</td>
	                            					<td class="text-center">{!! optional($background->period_to)->format('F d, Y') !!}</td>
	                            					<td class="text-center">{!! $background->units_earned !!}</td>
	                            					<td class="text-center">{!! $background->year_graduated !!}</td>
	                            					<td class="text-center">{!! $background->scholarship !!}</td>
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
		                    <span class="float-left mx-auto w-100">Educational Background</span>
		                </div>
		            </div>
		            <div class="modal-body">
		                <div id="formContainer"></div>
		            </div>
		        </div>
		    </div>
		</div>
    @endsection
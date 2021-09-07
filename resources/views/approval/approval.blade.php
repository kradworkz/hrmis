	@extends('layouts.content')
	@section('content')
		@include('approval.cards')
		<div class="row mb-3">
			<div class="col-md-12">
				<div class="card">
					@include('approval.nav')
					<div class="card-body">
						<div class="d-flex justify-content-between">
							<form action="{{ route('Approval', ['quarter_id' => $quarter_id]) }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Quarter</span>
                                    </div>
                                    <select name="quarter_id" class="form-control form-control-sm rounded-0">
                                        <option value="1" {{ old('quarter_id', $quarter_id) == '1' ? 'selected' : '' }}>1st Quarter</option>
                                        <option value="2" {{ old('quarter_id', $quarter_id) == '2' ? 'selected' : '' }}>2nd Quarter</option>
                                        <option value="3" {{ old('quarter_id', $quarter_id) == '3' ? 'selected' : '' }}>3rd Quarter</option>
                                        <option value="4" {{ old('quarter_id', $quarter_id) == '4' ? 'selected' : '' }}>4th Quarter</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-sm ml-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Year</span>
                                    </div>
                                    <select name="year" class="form-control form-control-sm rounded-0">
                                        @foreach($years as $y)
                                            <option value="{!! $y !!}" {{ $year == $y ? 'selected' : (old('year') == $y ? 'selected' : '') }}>{!! $y !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                               	<div class="input-group input-group-sm ml-2">
                               		<input type="Submit" class="btn btn-primary btn-sm rounded-0">
                               	</div>
                            </form>
							<div class="text-nowrap">
								<small class="font-weight-bold">Legend: </small>
								<span class="badge badge-primary">&nbsp&nbsp</span> <small>Approval</small> 
								<span class="badge badge-success">&nbsp&nbsp</span> <small>Recommending</small>
								<span class="badge badge-warning">&nbsp&nbsp</span> <small>Unit Head</small>
								<span class="badge badge-info">&nbsp&nbsp</span> <small>Notification</small> 
							</div>
						</div>
					</div>
					@if(count($signatories))
						<div class="table-responsive">
							<table class="table table-sm table-hover mb-0">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Module(s)</th>
									</tr>
								</thead>
								<tbody>
									@foreach($signatories as $sgty)
										<tr>
											<td>{!! $loop->iteration !!}</td>
											<td>{!! $sgty->employee->full_name !!}</td>
											<td>
												@foreach($sgty->employee->signatories as $mod)
												<a href="#" data-toggle="tooltip" data-title="{!! $mod->group_names() !!}">
													@if($mod->signatory == 'Approval')
														<span class="badge badge-primary">
													@elseif($mod->signatory == 'Recommending' || $mod->signatory == 'Chief HR' || $mod->signatory == 'Recommending FAS')
														<span class="badge badge-success">
													@elseif($mod->signatory == 'Notification')
														<span class="badge badge-info">
													@elseif($mod->signatory == 'Unit Head')
														<span class="badge badge-warning">
													@endif
														{!! $mod->module->name !!}
													</span>
												</a>
												@endforeach
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
			        	</div>
					@endif
				</div>
			</div>
		</div>
	@endsection
@extends('layouts.content')
    @section('content')
        <div class="row pb-4">
            <div class="col-md-12">
                <div class="card">
                	<h6 class="card-header">
						<small class="text-primary font-weight-bold">Graphs</small>
					</h6>
                	<div class="card-body">
                		<form action="{{ route('Approval Report') }}" class="form-inline">
                			<div class="input-group input-group-sm">
		                        <div class="input-group-prepend">
		                            <span class="input-group-text rounded-0">Module</span>
		                        </div>
		                        <select name="module" class="form-control form-control-sm rounded-0" id="module">
		                            @foreach($modules as $m)
		                                <option value="{!! $m !!}" {{ $module == $m ? 'selected' : (old('module') == $m ? 'selected' : '') }}>{!! $m !!}</option>
		                            @endforeach
		                        </select>
		                    </div>
		                	<div class="input-group input-group-sm ml-2">
		                        <div class="input-group-prepend">
		                            <span class="input-group-text rounded-0">Year</span>
		                        </div>
		                        <select name="year" class="form-control form-control-sm rounded-0" id="year">
		                            @foreach($years as $y)
		                                <option value="{!! $y !!}" {{ $year == $y ? 'selected' : (old('year') == $y ? 'selected' : '') }}>{!! $y !!}</option>
		                            @endforeach
		                        </select>
		                    </div>
		                    <div class="input-group ml-2">
                				<input type="Submit" class="btn btn-primary btn-sm rounded-0">
                			</div>
	                   	</form>
	                </div>
	            </div>
	        </div>
	    </div>
       	<div class="row">
       		<div class="col-md-12">
       			<div class="card">
       				<div class="card-body pr-4 report-height">
	       				<canvas id="report" width="400" height="500"></canvas>
	       			</div>
       			</div>
       		</div>
       	</div>
    @endsection
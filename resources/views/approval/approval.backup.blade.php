<div class="row mb-3">
	<div class="col-md-12">
		<div class="card">
			@include('approval.nav')
			<div class="card-body">
				<form action="{{ route('Approval', ['module_id' => $module_id]) }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                    <div class="input-group input-group-sm">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Module</span>
                            </div>
                            <select name="module_id" class="form-control form-control-sm rounded-0">
                                @foreach($modules as $module)
                                    <option value="{!! $module->id !!}" {{ $module_id == $module->id ? 'selected' : (old('module_id') == $module->id ? 'selected' : '') }}>{!! $module->name !!}</option>
                                @endforeach
                            </select>
                        </div>
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
			</div>
			@if(count($approvals))
			<div class="table-responsive">
			    <table class="table table-hover pb-0 mb-0">
			        <thead>
			            <tr>
			                <th>#</th>
			                <th>Created By</th>
			                <th>Created At</th>
			                <th>Approved At</th>
			                <th>Pending Time</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@foreach($approvals as $approval)
			        		@if($approval->reference)
				        		<tr>
				        			<td>{!! $loop->iteration !!}</td>
				        			<td>{!! $approval->reference->employee->full_name !!}</td>
				        			<td>{!! $approval->reference->created_at->format('F d, Y h:i A') !!}</td>
				        			<td>{!! $approval->created_at->format('F d, Y h:i A') !!}</td>
				        			<td>
				        				@if($approval->reference->created_at->diffInHours($approval->created_at) == 0)
				        					{!! $approval->reference->created_at->diffInMinutes($approval->created_at)." minute(s)" !!}
				        				@elseif($approval->reference->created_at->diffInDays($approval->created_at) == 0)
				        					{!! $approval->reference->created_at->diffInMinutes($approval->created_at)." minute(s)" !!}
				        				@else
				        					{!! $approval->reference->created_at->diffInDays($approval->created_at)." days(s)" !!}	
				        				@endif
				        			</td>
				        		</tr>
				        	@endif
			        	@endforeach
			        </tbody>
			    </table>
			</div>
		@endif
		</div>
	</div>
</div>
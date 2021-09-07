@extends('layouts.content')
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					@include('approval.nav')
					<div class="card-body">
					    <div class="d-flex align-items-center">
					        <form action="{{ route($route, ['id' => isset($id) ? $id : null]) }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
					        	@if(!Auth::user()->is_superuser())
					            <div class="input-group input-group-sm">
				                    <div class="input-group-prepend">
				                        <span class="input-group-text rounded-0">Status</span>
				                    </div>
				                    <select name="status" class="form-control form-control-sm rounded-0">
				                        <option value="0" {{ old('status', $status) == 0 ? 'selected' : '' }}>Pending</option>
				                        <option value="1" {{ old('status', $status) == 1 ? 'selected' : '' }}>Approved</option>
				                        <option value="2" {{ old('status', $status) == 2 ? 'selected' : '' }}>Disapproved</option>
				                    </select>
					             </div>
					             @endif
				                <div class="input-group input-group-sm ml-2">
				                    <div class="input-group-prepend">
				                        <span class="input-group-text rounded-0"><i class="fa fa-search"></i></span>
				                    </div>
				                    <input type="text" name="search" class="form-control form-control-sm rounded-0 mr-2" placeholder="Search">
				                </div>
					            <input type="Submit" class="btn btn-primary btn-sm rounded-0">
					        </form>
					    </div>
					</div>
					@include('approval.leave.table')
					@if($leave->total() >= 21)
					<div class="card-footer">
						{{ $leave->appends(Request::only('status', 'search'))->links('vendor.pagination.bootstrap-4') }}
	                </div>
	                @endif
				</div>
			</div>
		</div>
	@endsection
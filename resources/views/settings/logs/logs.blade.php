@extends('layouts.content')
    @section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('settings.nav')
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <form action="{{ route($route, ['id' => isset($id) ? $id : null]) }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Employee</span>
                                    </div>
                                    <select name="employee_id" class="form-control form-control-sm rounded-0">
                                        <option value="">-- Select Employee --</option>
                                        @foreach($employees as $employee)
                                            <option value="{!! $employee->id !!}" {{ old('employee_id', $employee_id) == $employee->id ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-sm ml-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input type="date" name="date" value="{{ old('date', $date) }}" class="form-control form-control-sm rounded-0 mr-2">
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(count($logs))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee Name</th>
                                    <th>IP Address</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{!! $loop->iteration !!}</td>
                                        <td>{!! $log->employee->full_name !!}</td>
                                        <td>{!! $log->ip_address !!}</td>
                                        <td>{!! $log->created_at->format('F d, Y h:i A') !!}</td>
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
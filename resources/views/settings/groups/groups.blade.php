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
                                        <span class="input-group-text rounded-0"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="text" name="search" class="form-control form-control-sm rounded-0 mr-2" placeholder="Search">
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(count($groups))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Alias</th>
                                    <th class="text-center">Vehicle Reservation</th>
                                    <th class="text-center">Travel Order</th>
                                    <th class="text-center">Leave</th>
                                    <th class="text-center">Offset</th>
                                    <th class="text-center">Overtime Request</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                @foreach($groups as $group)
                                <tr class="clickable-row" data-tab="no" data-href="{{ route('Edit Group', ['id' => $group->id]) }}">
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->alias }}</td>
                                    <td class="text-center">
                                        <i class="fa {{ $group->recommending == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Recommending"></i>
                                        <i class="fa {{ $group->approval == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Approval"></i>
                                    </td>
                                    <td class="text-center">
                                        <i class="fa {{ $group->travel_recommending == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Recommending"></i>
                                        <i class="fa {{ $group->travel_approval == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Approval"></i>
                                    </td>
                                    <td class="text-center">
                                        <i class="fa {{ $group->chief_approval == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Chief HR"></i>
                                        <i class="fa {{ $group->leave_recommending == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Recommending"></i>
                                        <i class="fa {{ $group->leave_approval == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Approval"></i>
                                    </td>
                                    <td class="text-center">
                                        <i class="fa {{ $group->offset_recommending == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Recommending"></i>
                                        <i class="fa {{ $group->offset_approval == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Approval"></i>
                                    </td>
                                    <td class="text-center">
                                        <i class="fa {{ $group->overtime_recommending == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Recommending"></i>
                                        <i class="fa {{ $group->overtime_approval == 1 ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" data-toggle="tooltip" title="Approval"></i>
                                    </td>
                                    <td class="text-center"><small class="font-weight-bold">@if($group->is_active == 1)<i class="text-success">ACTIVE</i>@else<i class="text-danger">INACTIVE</i>@endif</small></td>
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
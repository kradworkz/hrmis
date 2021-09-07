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
                    @if(count($modules))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center">Primary</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                @foreach($modules as $module)
                                <tr class="clickable-row" data-tab="no" data-href="{{ route('Edit Module', ['id' => $module->id]) }}">
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $module->name }}</td>
                                    <td class="text-center"><small class="font-weight-bold">@if($module->is_primary == 1)<i class="text-success">YES</i>@else<i class="text-danger">NO</i>@endif</small></td>
                                    <td class="text-center"><small class="font-weight-bold">@if($module->is_active == 1)<i class="text-success">ACTIVE</i>@else<i class="text-danger">INACTIVE</i>@endif</small></td>
                                    <td class="text-right">
                                        <a href="{{ route('Edit Module', ['id' => $module->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
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
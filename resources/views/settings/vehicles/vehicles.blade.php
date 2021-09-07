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
                    @if(count($vehicles))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Plate Number</th>
                                    <th>Office</th>
                                    <th>Location</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                @foreach($vehicles as $vehicle)
                                <tr class="clickable-row" data-tab="no" data-href="{{ route('Edit Vehicle', ['id' => $vehicle->id]) }}">
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $vehicle->plate_number }}</td>
                                    <td>{{ $vehicle->group == null ? '' : $vehicle->group->name }}</td>
                                    <td>{{ $vehicle->location == 1 ? 'Regional Office' : 'Provincial Office' }}</td>
                                    <td class="text-center"><small class="font-weight-bold">@if($vehicle->is_active == 1)<i class="text-success">ACTIVE</i>@else<i class="text-danger">INACTIVE</i>@endif</small></td>  
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



@extends('layouts.content')
    @section('content')
    	@include('profile.cards.cards')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    @include('profile.nav')
                    <div class="card-body">
                    	<div class="d-flex align-items-center">
                            <form action="{{ route($route, ['id' => isset($id) ? $id : null]) }}" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                                <div class="input-group input-group-sm ml-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="text" name="search" class="form-control form-control-sm rounded-0 mr-2" placeholder="Search">
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(count($quarantine))
                        <div class="table-responsive">
                            <table class="table table-hover pb-0 mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap">#</th>
                                        <th class="text-nowrap">Date Declared</th>
                                        <th class="text-nowrap">Recommendation</th>
                                        <th class="text-nowrap">Endorsed By</th>
                                        <th width="30%">Remarks</th>
                                        <th class="text-nowrap">Quarantine Start Date</th>
                                        <th class="text-nowrap">Quarantine End Date</th>
                                        <th class="text-center">Temperature</th>
                                        <th class="text-nowrap">Health Declaration</th>
                                        <th class="text-nowrap">Monitor Symptoms</th>
                                        <th class="text-nowrap">Report to Local Authorities</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quarantine as $q)
                                        <tr>
                                            <td>{!! $loop->iteration !!}</td>
                                            <td>{!! $q->health_declaration->date->format('F d, Y') !!}</td>
                                            <td>{!! $q->recommendation !!}</td>
                                            <td>{!! $q->endorsed->full_name !!}</td>
                                            <td>{!! $q->remarks !!}</td>
                                            <td>{!! $q->start_date != null ? $q->start_date->format('F d, Y') : '' !!}</td>
                                            <td>{!! $q->end_date != null ? $q->end_date->format('F d, Y') : '' !!}</td>
                                            <td class="text-center">{!! $q->health_declaration->temperature !!}</td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">{{ $q->health_declaration->fever }}</span> 
                                                <span class="badge badge-danger">{{ $q->health_declaration->cough }}</span> 
                                                <span class="badge badge-info">{{ $q->health_declaration->ache != NULL ? 'Aches and Pains' : '' }}</span> 
                                                <span class="badge badge-secondary">{{ $q->health_declaration->runny_nose }}</span> 
                                                <span class="badge badge-warning">{{ $q->health_declaration->shortness_of_breath }}</span> 
                                                <span class="badge badge-success">{{ $q->health_declaration->diarrhea }}</span>
                                                <span class="badge bg-light">{{ $q->health_declaration->sore_throat }}</span>
                                                <span class="badge badge-dark">{{ $q->health_declaration->loss_of_taste }}</span>
                                            </td>
                                            <td class="text-center">{!! $q->monitor_health ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                            <td class="text-center">{!! $q->report_local ? '<i class="fa fa-check text-success"></i>' : '' !!}</td>
                                            <td class="text-right">
                                                <a href="{{ route('View Home Quarantine', ['id' => $q->id]) }}" data-toggle="tooltip" data-title="View"><i class="fa fa-eye"></i></a>
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

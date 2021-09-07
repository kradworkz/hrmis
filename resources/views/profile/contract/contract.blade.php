@extends('layouts.content')
    @section('content')
        @include('profile.cards.cards')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    @include('profile.nav')
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <form action="#" class="form-inline float-left mx-auto w-100" method="GET" autocomplete="off">
                                <div class="input-group input-group-sm">
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
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="text" name="search" class="form-control form-control-sm rounded-0 mr-2" placeholder="Search">
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                    <a href="{{ route('New Job Contract') }}" class="btn btn-success btn-sm rounded-0 ml-2">New Contract</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(count($contracts))
                        <div class="table-responsive">
                            <table class="table table-hover pb-0 mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-nowrap">Contract Duration</th>
                                        <th class="text-nowrap">Employment Title</th>
                                        <th class="text-nowrap">Salary Rate</th>
                                        <th class="text-nowrap">Created At</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contracts as $contract)
                                    <tr>
                                        <td class="text-nowrap">{{ $loop->iteration }}.</td>
                                        <td>{!! $contract->contract_duration !!}</td>
                                        <td>{!! $contract->employment_title !!}</td>
                                        <td>{!! $contract->salary_rate !!}</td>
                                        <td>{!! $contract->created_at->format('F d, Y h:i A') !!}</td>
                                        <td class="text-right">
                                            <a href="{{ route('Download Job Contract', ['contract' => $contract->id]) }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download text-success fa-fw"></i></a>
                                            <a href="{{ route('Edit Job Contract', ['id' => $contract->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit fa-fw"></i></a>
                                            <span data-href="{{ route('Delete Job Contract', ['id' => $contract->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
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
    @include('layouts.confirmation')
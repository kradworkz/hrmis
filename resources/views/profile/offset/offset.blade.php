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
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0">Month</span>
                                        </div>
                                        <select name="month" class="form-control form-control-sm rounded-0">
                                            @foreach($months as $key => $m)
                                                <option value="{!! $key !!}" {{ $month == $key ? 'selected' : (old('month') == $key ? 'selected' : '') }}>{!! $m !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group input-group-sm ml-2">
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0">
                                </div>
                            </form>
                        </div>
                    </div>
                    @include('profile.offset.table')
                </div>
            </div>
        </div>
    @endsection
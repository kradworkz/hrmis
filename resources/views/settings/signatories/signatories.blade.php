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
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0">Module</span>
                                        </div>
                                        <select name="module" class="form-control form-control-sm rounded-0">
                                            <option value="">-- Sort by Module --</option>
                                            @foreach($modules as $module)
                                                <option value="{!! $module->id !!}" {{ $module_id == $module->id ? 'selected' : (old('module') == $module->id ? 'selected' : '') }}>{!! $module->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="Submit" class="btn btn-primary btn-sm rounded-0 ml-2">
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(count($signatories))
                    <div class="table-responsive">
                        <table class="table table-hover pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Signatory</th>
                                    <th>Module</th>
                                    <th class="text-center">Groups</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                @foreach($signatories as $signatory)
                                <tr class="clickable-row" data-tab="no" data-href="{{ route('Edit Signatory', ['id' => $signatory->id]) }}">
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{!! $signatory->employee->full_name !!}</td>
                                    <td>{!! $signatory->signatory !!}</td>
                                    <td>{!! $signatory->module->name !!}</td>
                                    <td class="text-center"><a class="text-primary" data-toggle="tooltip" data-placement="top" title="{{ $signatory->group_names() }}" href="#">{{ $signatory->groups_count }}</a></td>
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
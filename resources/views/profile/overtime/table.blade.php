@if(count($overtime_request))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-nowrap">Date of otr</th>
                <th class="text-nowrap">Purpose</th>
                <th class="text-center">Status</th>
                <th class="text-center text-nowrap">Created At</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($overtime_request as $otr)
            <tr>
                <td class="text-nowrap">{{ $loop->iteration }}. <i class="fa {{ $otr->employee_id == Auth::id() ? 'fa fa-check-circle text-success' : 'fa fa-user-circle text-primary' }} fa-fw" data-toggle="tooltip" title="{{ $otr->employee_id == Auth::id() ? 'Created by you.' : 'Created By '.$otr->employee->full_name.'.' }}"></i></td>
                <td class="text-nowrap"><a class="text-primary" data-toggle="tooltip" data-placement="auto" title="{{ $otr->overtime_personnel_names() }}" href="#">{!! $otr->overtime_dates !!}</a></td>
                <td>{!! nl2br($otr->purpose) !!}</td>
                <td class="text-center">@include('layouts.status', ['approvals' => $otr])</td>
                <td class="text-center text-nowrap">{!! $otr->created_at->format('F d, Y h:i A') !!}</td>
                <td class="text-right">
                @if(Request::segment(1) == 'profile')
                    <a href="{{ route('Print Overtime', ['id' => $otr->id]) }}" data-toggle="tooltip" data-placement="top" title="Print" target="_blank"><i class="fa fa-print text-info fa-fw"></i></a>
                    @if(Auth::id() == $otr->employee_id)
                        <a href="{{ route('Edit Overtime Request', ['id' => $otr->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit fa-fw"></i></a>
                        <span data-href="{{ route('Delete Overtime Request', ['id' => $otr->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
                    @else
                        <a href="{{ route('View Overtime Request', ['id' => $otr->id]) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye text-dark fa-fw"></i></a>
                        <span data-href="{{ route('Remove Overtime Request Tag', ['id' => $otr->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Remove Tag"><i class="fa fa-tag text-danger fa-fw"></i></a></span>
                    @endif
                @else
                    <span data-href="{{ route('Remove Overtime Request Tag', ['id' => $otr->id, 'employee_id' => $id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Remove Tag"><i class="fa fa-tag text-primary fa-fw"></i></a></span>
                    <span data-href="{{ route('Delete Overtime Request', ['id' => $otr->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
                @endif
                </td>   
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@include('layouts.confirmation')
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-0">
            <h6 class="modal-header mb-0">Overtime Request</h6>
            <div class="modal-body p-0">
                <div id="statusContainer"></div>
            </div>
        </div>
    </div>
</div>
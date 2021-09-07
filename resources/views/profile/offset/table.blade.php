@if(count($offset))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Time</th>
                <th class="text-center">Hours</th>
                <th class="text-center">Status</th>
                <th class="text-center">Created At</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($offset as $off)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $off->date->format('F d, Y') }}</td>
                <td>{{ $off->time }}</td>
                <td class="text-center">{{ $off->hours }}</td>
                <td class="text-center">@include('layouts.status', ['approvals' => $off])</td>
                <td class="text-center">{!! $off->created_at->format('F d, Y h:i A') !!}</td>
                <td class="text-right">
                @if($off->is_active == 1)
                    <a href="{{ route('View Offset', ['id' => $off->id]) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye text-success fa-fw"></i></a>
                    <a href="{{ route('Print Offset', ['id' => $off->id]) }}" data-toggle="tooltip" data-placement="top" title="Print" target="_blank"><i class="fa fa-print text-info fa-fw"></i></a>
                    @if($off->recommending == 0 && $off->approval == 0)
                        <a href="{{ route('Edit Offset', ['id' => $off->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit fa-fw"></i></a>
                        <span data-href="{{ route('Cancel Offset', ['id' => $off->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
                    @endif
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
            <h6 class="modal-header mb-0">Offset</h6>
            <div class="modal-body p-0">
                <div id="statusContainer"></div>
            </div>
        </div>
    </div>
</div>
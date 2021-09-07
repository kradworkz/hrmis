@if(count($leave))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-nowrap">Date</th>
                <th class="text-nowrap">Type</th>
                <th class="text-center">Status</th>
                <th class="text-center">Created At</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leave as $off)
            <tr>
                <td class="text-nowrap">{{ $loop->iteration }}.</td>
                <td class="text-nowrap">{!! $off->off_dates !!}</a></td>
                <td class="text-nowrap">{!! $off->type !!}</td>
                <td class="text-center">@include('layouts.status', ['approvals' => $off])</td>
                <td class="text-center text-nowrap">{!! $off->created_at->format('F d, Y h:i A') !!}</td>
                <td class="text-right">
                <a href="{{ route('View Leave', ['id' => $off->id]) }}" data-toggle="tooltip" data-placement="top" title="View" target="_blank"><i class="fa fa-eye text-dark fa-fw"></i></a>
                <a href="{{ route('Print Leave', ['id' => $off->id]) }}" data-toggle="tooltip" data-placement="top" title="Print" target="_blank"><i class="fa fa-print text-info fa-fw"></i></a>
                @if(Request::segment(1) == 'profile')
                    @if($off->hr_approval == 0)
                        <a href="{{ route('Edit Leave', ['id' => $off->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit fa-fw"></i></a>
                        <span data-href="{{ route('Delete Leave', ['id' => $off->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
                    @endif
                @else
                    <span data-href="{{ route('Delete Leave', ['id' => $off->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@include('layouts.confirmation')
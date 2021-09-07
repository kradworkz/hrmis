@if(count($travels))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-nowrap">Date of Travel</th>
                <th class="text-nowrap">Destination</th>
                <th class="text-center">Status</th>
                <th class="text-center">Created At</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($travels as $travel)
            <tr>
                <td class="text-nowrap">{{ $loop->iteration }}. <i class="fa {{ $travel->employee_id == Auth::id() ? 'fa fa-check-circle text-success' : 'fa fa-user-circle text-primary' }} fa-fw" data-toggle="tooltip" title="{{ $travel->employee_id == Auth::id() ? 'Created by you.' : 'Created By '.$travel->employee->full_name.'.' }}"></i></td>
                <td class="text-nowrap"><a class="text-primary" data-toggle="tooltip" data-placement="top" title="{{ $travel->travel_passenger_names() }}" href="#">{!! $travel->travel_dates !!}</a></td>
                <td class="w-50 mw-0 long-text"><a class="text-primary" data-toggle="tooltip" data-placement="right" title="{{ $travel->purpose }}" href="#">{!! nl2br($travel->destination) !!}</a></td>
                <td class="text-center">@include('layouts.status', ['approvals' => $travel])</td>
                <td class="text-center text-nowrap">{!! $travel->created_at->format('F d, Y h:i A') !!}</td>
                <td class="text-right">
                <a href="{{ route('Print Travel Order', ['id' => $travel->id]) }}" data-toggle="tooltip" data-placement="top" title="Print" target="_blank"><i class="fa fa-print text-info fa-fw"></i></a>
                @if(Request::segment(1) == 'profile')
                    @if(Auth::id() == $travel->employee_id)
                        <a href="{{ route('Edit Travel Order', ['id' => $travel->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit fa-fw"></i></a>
                        <span data-href="{{ route('Delete Travel Order', ['id' => $travel->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
                    @else
                        <a href="{{ route('View Travel Order', ['id' => $travel->id]) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye text-dark fa-fw"></i></a>
                        <span data-href="{{ route('Remove Travel Tag', ['id' => $travel->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Remove Tag"><i class="fa fa-tag text-danger fa-fw"></i></a></span>
                    @endif
                @else
                    <span data-href="{{ route('Remove Travel Tag', ['id' => $travel->id, 'employee_id' => $id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Remove Tag"><i class="fa fa-tag text-primary fa-fw"></i></a></span> 
                    <span data-href="{{ route('Delete Travel Order', ['id' => $travel->id]) }}" data-toggle="modal" data-target="#confirmationModal"><a href="#" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus-circle text-danger fa-fw"></i></a></span>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@include('layouts.confirmation')
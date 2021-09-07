@if(count($travels))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
        	<tr>
        		<th>#</th>
                <th class="text-nowrap">Requested By</th>
                <th>Date of Travel</th>
                <th class="text-left">Destination</th>
                <th class="text-left">Purpose</th>
        	</tr>
        </thead>
        <tbody>
        	@foreach($travels as $travel)
            <tr class="clickable-row" data-toggle="modal" data-target="#approvalModal" data-url="{{ route('Edit Travel Approval', ['id' => $travel->id]) }}" data-view="{{ route('View Travel Approval', ['id' => $travel->id]) }}">
                <td>{{ $loop->iteration }}.</td>
                <td class="text-nowrap" width="10%">
                	<div>@if($travel->checked == 1) <i class="fa fa-check-circle text-success" data-toggle="tooltip" data-title="Checked By: {{ $travel->inspected_by->full_name }}"></i>@endif {{ $travel->employee->full_name }}</div>
                	<small><i>{!! $travel->created_at->diffForHumans() !!}</i></small>
                </td>
                <td class="text-nowrap" width="10%">
                	<div><a class="text-primary" data-toggle="tooltip" data-placement="top" title="{{ $travel->travel_passenger_names() }}" href="#">{!! $travel->travel_dates !!}</a></div>
                    <small>{!! $travel->start_date->lte(Carbon\Carbon::parse($travel->created_at)) ? ($travel->start_date->diffInDays(Carbon\Carbon::parse($travel->created_at)) > 3 ? '<strong class="text-danger"><i>'.$travel->start_date->diffInDays(Carbon\Carbon::parse($travel->created_at)). ' days late</i></strong>' : '<strong class="text-success"><i>ON TIME</i></strong>') : '<strong class="text-success"><i>ON TIME</i></strong>' !!}</small>
                </td>
                <td class="word-break text-left" width="30%">{!! nl2br($travel->destination) !!}</td>
                <td class="word-break text-left" width="50%">{!! nl2br($travel->purpose) !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-0">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <span class="float-left mx-auto w-100">Travel Order</span>
                    <a href="#" target="_blank" id="viewBtn" class="badge badge-primary rounded-0">VIEW</a>
                </div>
            </div>
            <div class="modal-body">
                <div id="formContainer"></div>
            </div>
        </div>
    </div>
</div>
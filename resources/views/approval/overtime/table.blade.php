@if(count($overtime))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
        	<tr>
        		<th>#</th>
                <th class="text-nowrap">Requested By</th>
                <th class="text-nowrap">Unit</th>
                <th>Date</th>
                <th class="text-left">Purpose</th>
        	</tr>
        </thead>
        <tbody>
        	@foreach($overtime as $otr)
            <tr class="clickable-row" data-toggle="modal" data-target="#approvalModal" data-url="{{ route('Edit Overtime Approval', ['id' => $otr->id]) }}" data-view="{{ route('View Overtime Approval', ['id' => $otr->id]) }}">
                <td>{{ $loop->iteration }}.</td>
                <td class="text-nowrap">
                	<div>@if($otr->checked == 1) <i class="fa fa-check-circle text-success" data-toggle="tooltip" data-title="Checked By: {{ $otr->inspected_by->full_name }}"></i>@endif {{ $otr->employee->full_name }}</div>
                	<small><i>{!! $otr->created_at->diffForHumans() !!}</i></small>
                </td>
                <td class="text-nowrap">{!! $otr->employee->unit->name !!}</td>
                <td class="text-nowrap">
                	<div><a class="text-primary" data-toggle="tooltip" data-placement="top" title="{{ $otr->overtime_personnel_names() }}" href="#">{!! $otr->overtime_dates !!}</a></div>
                    <small>{!! $otr->start_date->lte(Carbon\Carbon::parse($otr->created_at)) ? ($otr->start_date->diffInDays(Carbon\Carbon::parse($otr->created_at)) > 3 ? '<strong class="text-danger"><i>'.$otr->start_date->diffInDays(Carbon\Carbon::parse($otr->created_at)). ' days late</i></strong>' : '<strong class="text-success"><i>ON TIME</i></strong>') : '<strong class="text-success"><i>ON TIME</i></strong>' !!}</small>
                </td>
                <td class="word-break text-left" width="50%">{!! nl2br($otr->purpose) !!}</td>
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
                    <span class="float-left mx-auto w-100">Overtime Request</span>
                    <a href="#" target="_blank" id="viewBtn" class="badge badge-primary rounded-0">VIEW</a>
                </div>
            </div>
            <div class="modal-body">
                <div id="formContainer"></div>
            </div>
        </div>
    </div>
</div>
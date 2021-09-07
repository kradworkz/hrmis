@if(count($leave))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
        	<tr>
        		<th>#</th>
                <th class="text-nowrap">Requested By</th>
                <th>Date</th>
                <th>Remarks</th>
                <th class="text-left">Type of Leave</th>
        	</tr>
        </thead>
        <tbody>
        	@foreach($leave as $off)
            <tr class="clickable-row" data-toggle="modal" data-target="#approvalModal" data-url="{{ route('Edit Leave Approval', ['id' => $off->id]) }}" data-view="{{ route('View Leave Approval', ['id' => $off->id]) }}">
                <td>{{ $loop->iteration }}.</td>
                <td class="text-nowrap">
                	<div>{{ $off->employee->full_name }}</div>
                	<small><i>{!! $off->created_at->diffForHumans() !!}</i></small>
                </td>
                <td class="text-nowrap">{!! $off->off_dates !!}</td>
                <td>{!! $off->start_date->lte(Carbon\Carbon::parse($off->created_at)) ? ($off->start_date->diffInDays(Carbon\Carbon::parse($off->created_at)) > 3 ? '<strong class="text-danger"><i>'.$off->start_date->diffInDays(Carbon\Carbon::parse($off->created_at)). ' days late</i></strong>' : '<strong class="text-success"><i>ON TIME</i></strong>') : '<strong class="text-success"><i>ON TIME</i></strong>' !!}</td>
                <td>{!! $off->type!!}</td>
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
                    <span class="float-left mx-auto w-100">Leave</span>
                    <a href="#" target="_blank" id="viewBtn" class="badge badge-primary rounded-0">VIEW</a>
                </div>
            </div>
            <div class="modal-body">
                <div id="formContainer"></div>
            </div>
        </div>
    </div>
</div>
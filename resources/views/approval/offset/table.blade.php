@if(count($offset))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
        	<tr>
        		<th>#</th>
                <th>Requested By</th>
                <th>Date</th>
                <th>Time</th>
                <th class="text-center">Hour(s)</th>
                <th class="text-center">Remarks</th>
        	</tr>
        </thead>
        <tbody>
        	@foreach($offset as $off)
            <tr class="clickable-row" data-toggle="modal" data-target="#approvalModal" data-url="{{ route('Edit Offset Approval', ['id' => $off->id]) }}" data-view="{{ route('View Offset Approval', ['id' => $off->id]) }}">
                <td>{{ $loop->iteration }}.</td>
                <td><div>{!! $off->employee->full_name !!}</div><small><i>{!! $off->created_at->diffForHumans() !!}</i></small></td>
                <td class="text-nowrap">
                    <div>{!! $off->date->format('F d, Y') !!}</div>
                    <small><i>{!! $off->date->lte(Carbon\Carbon::parse($off->created_at)) ? ($off->date->diffInDays(Carbon\Carbon::parse($off->created_at)) > 3 ? '<strong class="text-danger"><i>'.$off->date->diffInDays(Carbon\Carbon::parse($off->created_at)). ' days late</i></strong>' : '<strong class="text-success"><i>ON TIME</i></strong>') : '<strong class="text-success"><i>ON TIME</i></strong>' !!}</i></small>
                </td>
                <td>{!! $off->time !!}</td>
                <td class="text-center">{!! $off->hours !!}</td>
                <td class="text-center">{!! nl2br($off->remarks) !!}</td>
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
                    <span class="float-left mx-auto w-100">Offset</span>
                    <a href="#" target="_blank" id="viewBtn" class="badge badge-primary rounded-0">VIEW</a>
                </div>
            </div>
            <div class="modal-body">
                <div id="formContainer"></div>
            </div>
        </div>
    </div>
</div>
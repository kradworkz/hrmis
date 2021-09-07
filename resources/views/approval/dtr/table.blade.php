@if(count($dtr))
<div class="table-responsive">
    <table class="table table-hover pb-0 mb-0">
        <thead>
        	<tr>
        		<th>#</th>
                <th class="text-nowrap">Requested By</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Location</th>
                <th>Attachments</th>
                <th class="text-right"></th>
        	</tr>
        </thead>
        <tbody>
        	@foreach($dtr as $row)
            <tr>   
                <td>{{ $loop->iteration }}.</td>
                <td class="text-nowrap">{!! $row->employee->full_name !!}</td>
                <td>{!! $row->time_in->format('F d, Y') !!}</td>
                <td>{!! $row->time_in->format('h:i A') !!}</td>
                <td>{!! optional($row->time_out)->format('h:i A') !!}</td>
                <td>@if($row->location == 0) Work from Home @else Office @endif</td>
                <td width="10%" class="text-nowrap">
                    @foreach($row->attachments as $attachment)
                        <div><a class="text-decoration-none" href="{{ route('Get File Attachment', ['filename' => $attachment->filename]) }}" target="_blank">{!! $attachment->title !!}</a></div>
                    @endforeach
                </td>
                <td class="text-right">
                    @if($row->status != 0)<a href="{{ route('Approve DTR', ['id' => $row->id, 'action' => 0]) }}" data-toggle="tooltip" data-placement="top" title="Pending"><i class="fa fa-exclamation-circle text-warning fa-fw"></i></a>@endif
                    @if($row->status != 1)<a href="{{ route('Approve DTR', ['id' => $row->id, 'action' => 1]) }}" data-toggle="tooltip" data-placement="top" title="Verify"><i class="fa fa-check-circle text-success fa-fw"></i></a>@endif
                    @if($row->status != 2)<a href="{{ route('Approve DTR', ['id' => $row->id, 'action' => 2]) }}" data-toggle="tooltip" data-placement="top" title="Disapprove"><i class="fa fa-minus-circle text-danger fa-fw"></i></a>@endif
                    <a href="#" class="clickable-row" data-toggle="modal" data-target="#approvalModal" data-url="{{ route('Edit DTR Approval', ['id' => $row->id]) }}" data-view="{{ route('View DTR Approval', ['id' => $row->id]) }}"><i class="fa fa-eye text-dark fa-fw" data-toggle="tooltip" data-placement="top" title="View"></i></a>
                </td>
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
                    <span class="float-left mx-auto w-100">Daily Time Record</span>
                    <a href="#" target="_blank" id="viewBtn" class="badge badge-primary rounded-0">VIEW</a>
                </div>
            </div>
            <div class="modal-body">
                <div id="formContainer"></div>
            </div>
        </div>
    </div>
</div>
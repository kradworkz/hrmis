<form action="{{ route('Submit Offset Approval', ['id' => $id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <div class="form-group mb-0">
        <label>Created By: <i class="text-primary font-weight-bold">{!! $offset->employee->full_name !!}</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Date: <i class="text-primary font-weight-bold">{!! $offset->date->format('F d, Y') !!}</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Time: <i class="text-primary font-weight-bold">{!! $offset->time !!}</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Hours: <i class="text-primary font-weight-bold">{!! $offset->hours !!}</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Remarks: <i class="text-primary font-weight-bold">{!! $offset->remarks !!}</i></label>
    </div>
    <div class="form-group mb-0">
        <label>Covid Positive: <i class="text-danger font-weight-bold">{!! $offset->is_positive == 1 ? 'Yes' : 'No' !!}</i></label>
    </div>
    @if($offset->is_positive == 1 && $offset->attachment)
    <div class="form-group">
        <label>Attachment: <a class="text-decoration-none" href="{{ route('Get File Attachment', ['filename' => $offset->attachment->filename]) }}" target="_blank"><i class="font-weight-bold">{!! $offset->attachment->title !!}</i></a></label>
    </div>
    @endif
    @if(count($approvals))
    <hr>
    <table class="table table-sm table-condensed table-borderless table-hover">
        <tbody>
            @foreach($approvals as $approval)
                <tr>
                    <td><i>{!! $approval->employee->full_name !!}</i></td>
                    <td>
                        @if($approval->action == 0)
                            <i class="text-warning font-weight-bold">PENDING</i>
                        @elseif($approval->action == 1)
                            <i class="text-success font-weight-bold">APPROVED</i>
                        @elseif($approval->action == 2)
                            <i class="text-danger font-weight-bold">DISAPPROVED</i>
                        @endif
                    </td>
                    <td class="text-right">{!! $approval->created_at->format('F d, Y h:i A') !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    @endif
	@include('layouts.signatory', ['signatory' => 'offset_signatory', 'module' => $offset])
</form>
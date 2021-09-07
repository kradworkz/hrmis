<form action="{{ route('Submit Overtime Approval', ['id' => $id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <div class="form-group mb-0">
        <label>Created By: <i class="text-primary font-weight-bold">{!! $overtime->employee->full_name !!}</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Date: <i class="text-primary font-weight-bold">{!! $overtime->overtime_dates !!}</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Employees: 
    		@foreach($overtime->overtime_personnel as $passenger)
    			<span class="badge badge-primary">{!! $passenger->full_name !!}</span>
    		@endforeach
    	</label>
    </div>
    <div class="form-group mb-0">
    	<label>Purpose: <div><i class="text-primary font-weight-bold">{!! nl2br($overtime->purpose) !!}</i></div></label>
    </div>
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
    @include('layouts.signatory', ['signatory' => 'overtime_signatory', 'module' => $overtime])
</form>
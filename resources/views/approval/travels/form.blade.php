<form action="{{ route('Submit Travel Approval', ['id' => $id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <div class="form-group mb-0">
        <label>Created By: <i class="text-primary font-weight-bold">{!! $travel->employee->full_name !!}</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Date: <i class="text-primary font-weight-bold">{!! $travel->travel_dates !!} @if($travel->time != null) {!! $travel->time !!}@endif</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Employees: 
    		@foreach($travel->travel_passengers as $passenger)
    			<span class="badge badge-primary">{!! $passenger->full_name !!}</span>
    		@endforeach
    	</label>
    </div>
    <div class="form-group mb-0">
    	<label>Purpose: <i class="text-primary font-weight-bold">{!! nl2br($travel->purpose) !!}</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Destination: <i class="text-primary font-weight-bold">{!! nl2br($travel->destination) !!}</i></label>
    </div>
    <div class="form-group mb-0">
        <label>Mode of Travel: <i class="text-primary font-weight-bold">{!! $travel->mode_of_travel !!}</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Remarks: <i class="text-primary font-weight-bold">{!! nl2br($travel->remarks) !!}</i></label>
    </div>
    <div class="form-group">
    	<label>Attachments:
    		@foreach($travel->travel_documents as $document)
    			<div><a class="text-decoration-none" href="{{ route('Get Travel Documents', ['filename' => $document->filename]) }}" target="_blank">{!! $document->title !!}</a></div>
    		@endforeach
    	</label>
    </div>
    <hr>
    <div class="form-group row">
		<div class="col-md-12 text-center"><label class="font-weight-bold">Travel Expenses</label></div>
	</div>
	<div class="form-group row">
		<div class="col-md-3 offset-md-3">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" name="fund_label" id="general_funds" class="custom-control-input" disabled>
                <label class="custom-control-label align-text" for="general_funds">General Funds</label>
            </div>
		</div>
		<div class="col-md-3">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" name="fund_label" id="project_funds" class="custom-control-input" disabled>
                <label class="custom-control-label align-text" for="project_funds">Project Funds</label>
            </div>
		</div>
		<div class="col-md-3">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" name="fund_label" id="others" class="custom-control-input" disabled>
                <label class="custom-control-label align-text" for="others">Others</label>
            </div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12 text-center"><label class="font-weight-bold">Actual</label></div>
	</div>
	@foreach($expenses as $key => $expense)
		@if($loop->iteration == 3)
		<div class="form-group row">
			<div class="col-md-12 text-center"><label class="font-weight-bold">Per Diem</label></div>
		</div>
		@endif
		<div class="form-group row">
			<div class="col-md-3 text-right">
				{!! $expense->name !!}
			</div>
			<div class="col-md-3">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" name="expense_id[]" value="{{ $expense->id.',1' }}" {{ in_array($expense->id.',1', old('expense_id') ?? []) ? 'checked' : (in_array($expense->id.',1', $tfexpenses ?? []) ? 'checked' : '') }} id="{{ $expense->name.'-'.$expense->id.'-1' }}" class="custom-control-input general_funds" disabled>
                    <label class="custom-control-label" for="{{ $expense->name.'-'.$expense->id.'-1' }}"></label>
                </div>
			</div>
			<div class="col-md-3">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" name="expense_id[]" value="{{ $expense->id.',2' }}" {{ in_array($expense->id.',2', old('expense_id') ?? []) ? 'checked' : (in_array($expense->id.',2', $tfexpenses ?? []) ? 'checked' : '') }} id="{{ $expense->name.'-'.$expense->id.'-2' }}" class="custom-control-input project_funds" disabled>
                    <label class="custom-control-label" for="{{ $expense->name.'-'.$expense->id.'-2' }}"></label>
                </div>
			</div>
			
			<div class="col-md-3">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" name="expense_id[]" value="{{ $expense->id.',3' }}" {{ in_array($expense->id.',3', old('expense_id') ?? []) ? 'checked' : (in_array($expense->id.',3', $tfexpenses ?? []) ? 'checked' : '') }} id="{{ $expense->name.'-'.$expense->id.'-3' }}" class="custom-control-input others" disabled>
                    <label class="custom-control-label" for="{{ $expense->name.'-'.$expense->id.'-3' }}"></label>
                </div>
			</div>
		</div>
	@endforeach
	<br>
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
    @include('layouts.signatory', ['signatory' => 'travel_signatory', 'module' => $travel])
</form>
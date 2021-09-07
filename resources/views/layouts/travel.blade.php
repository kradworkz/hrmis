<div class="form-group row">
    <div class="col-md-6">
        <label for="travel_documents[]">Travel Documents <i class="text-danger font-weight-bold">{{ $errors->first('document_path.*') }}</i></label>
        <input type="file" name="document_path[]" multiple class="form-control-file"> 
    </div>
	<div class="col-md-6">
        <label for="attachments">Attachments:</label>
        @isset($travel)
            @foreach($travel->travel_documents as $document)
                <div><a class="text-decoration-none" href="{{ route('Get Travel Documents', ['filename' => $document->filename]) }}" target="_blank">{!! $document->title !!}</a></div>
            @endforeach
        @endisset
    </div>
</div>
<div class="form-group row">
	<div class="col-md-12 text-center"><h5>Travel Expenses</h5></div>
</div>
<div class="form-group row">
	<div class="col-md-3 offset-md-3">
		<div class="custom-control custom-checkbox">
			<input type="checkbox" name="fund_label" id="general_funds" class="custom-control-input">
            <label class="custom-control-label" for="general_funds">General Funds</label>
        </div>
	</div>
	<div class="col-md-3">
		<div class="custom-control custom-checkbox">
			<input type="checkbox" name="fund_label" id="project_funds" class="custom-control-input">
            <label class="custom-control-label" for="project_funds">Project Funds</label>
        </div>
	</div>
	<div class="col-md-3">
		<div class="custom-control custom-checkbox">
			<input type="checkbox" name="fund_label" id="others" class="custom-control-input">
            <label class="custom-control-label" for="others">Others</label>
        </div>
	</div>
</div>
<div class="form-group row">
	<div class="col-md-12 text-center"><h5>Actual</h5></div>
</div>
@foreach($expenses as $key => $expense)
	@if($loop->iteration == 3)
	<div class="form-group row">
		<div class="col-md-12 text-center"><h5>Per Diem</h5></div>
	</div>
	@endif
	<div class="form-group row">
		<div class="col-md-3 text-right">
			{!! $expense->name !!}
		</div>
		<div class="col-md-3">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" name="expense_id[]" value="{{ $expense->id.',1' }}" {{ in_array($expense->id.',1', old('expense_id') ?? []) ? 'checked' : (in_array($expense->id.',1', $tfexpenses ?? []) ? 'checked' : '') }} id="{{ $expense->name.'-'.$expense->id.'-1' }}" class="custom-control-input general_funds">
                <label class="custom-control-label" for="{{ $expense->name.'-'.$expense->id.'-1' }}"></label>
            </div>
		</div>
		<div class="col-md-3">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" name="expense_id[]" value="{{ $expense->id.',2' }}" {{ in_array($expense->id.',2', old('expense_id') ?? []) ? 'checked' : (in_array($expense->id.',2', $tfexpenses ?? []) ? 'checked' : '') }} id="{{ $expense->name.'-'.$expense->id.'-2' }}" class="custom-control-input project_funds">
                <label class="custom-control-label" for="{{ $expense->name.'-'.$expense->id.'-2' }}"></label>
            </div>
		</div>
		<div class="col-md-3">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" name="expense_id[]" value="{{ $expense->id.',3' }}" {{ in_array($expense->id.',3', old('expense_id') ?? []) ? 'checked' : (in_array($expense->id.',3', $tfexpenses ?? []) ? 'checked' : '') }} id="{{ $expense->name.'-'.$expense->id.'-3' }}" class="custom-control-input others">
                <label class="custom-control-label" for="{{ $expense->name.'-'.$expense->id.'-3' }}"></label>
            </div>
		</div>
	</div>
@endforeach
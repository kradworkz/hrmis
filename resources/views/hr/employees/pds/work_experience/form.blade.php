<form action="{{ route('Submit Work Experience', ['id' => $id]) }}" method="POST" autocomplete="off">
	{{ csrf_field() }}
	<input type="integer" min="1" name="employee_id" value="{{ $employee->id }}" hidden>
    <div class="form-group">
        <label for="start_date">From <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('start_date') }}</i></label>
        <input type="date" name="start_date" value="{{ old('start_date', optional($work_exp->start_date)->format('Y-m-d')) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
        <label for="end_date">To <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('end_date') }}</i></label>
        <input type="date" name="end_date" value="{{ old('end_date', optional($work_exp->end_date)->format('Y-m-d')) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
        <label for="position_title">Position</label>
        <input type="text" name="position_title" value="{{ old('position_title', $work_exp->position_title) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="company">Company</label>
        <input type="text" name="company" value="{{ old('company', $work_exp->company) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="monthly_salary">Monthly Salary</label>
        <input type="text" name="monthly_salary" value="{{ old('monthly_salary', $work_exp->monthly_salary) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="salary_grade">Salary Grade</label>
        <input type="text" name="salary_grade" value="{{ old('salary_grade', $work_exp->salary_grade) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="status_of_appointment">Status of Appointment</label>
        <input type="text" name="status_of_appointment" value="{{ old('status_of_appointment', $work_exp->status_of_appointment) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
		<label>Government:</label>
		<div class="custom-control custom-radio">
			<input type="radio" name="is_government" value="1" {{ old('is_government', $work_exp->is_government == '1' ? 'checked' : '') }} class="custom-control-input" id="is_government_active">
			<label class="custom-control-label" for="is_government_active">Yes</label>
		</div>
		<div class="custom-control custom-radio">
			<input type="radio" name="is_government" value="0" {{ old('is_government', $work_exp->is_government == '0' ? 'checked' : '') }} class="custom-control-input" id="is_government_inactive">
			<label class="custom-control-label" for="is_government_inactive">No</label>
		</div>
	</div>
    <div class="form-group mb-0">
	    <input type="submit" name="Save" class="btn btn-primary btn-sm btn-block">
        @if($id != 0)<a href="{{ route('Delete Work Experience', ['id' => $id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>@endif
	</div>
</form>
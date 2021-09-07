<form action="{{ route('Submit Voluntary Work', ['id' => $id]) }}" method="POST" autocomplete="off">
	{{ csrf_field() }}
	<input type="integer" min="1" name="employee_id" value="{{ $employee->id }}" hidden>
    <div class="form-group">
        <label for="org_info">Name & Address of Organization</label>
        <input type="text" name="org_info" value="{{ old('org_info', $vol_work->org_info) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="start_date">From <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('start_date') }}</i></label>
        <input type="date" name="start_date" value="{{ old('start_date', optional($vol_work->start_date)->format('Y-m-d')) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
        <label for="end_date">To <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('end_date') }}</i></label>
        <input type="date" name="end_date" value="{{ old('end_date', optional($vol_work->end_date)->format('Y-m-d')) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
        <label for="number_of_hours">Number of Hours</label>
        <input type="text" name="number_of_hours" value="{{ old('number_of_hours', $vol_work->number_of_hours) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="position">Position</label>
        <input type="text" name="position" value="{{ old('position', $vol_work->position) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group mb-0">
	    <input type="submit" name="Save" class="btn btn-primary btn-sm btn-block">
        @if($id != 0)<a href="{{ route('Delete Voluntary Work', ['id' => $id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>@endif
	</div>
</form>
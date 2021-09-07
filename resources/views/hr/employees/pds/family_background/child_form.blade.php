<form action="{{ route('Submit Child', ['id' => $id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <input type="integer" min="1" name="employee_id" value="{{ $employee->id }}" hidden>
	<div class="form-group">
    	<label for="full_name">Full Name </label>
        <input type="text" name="full_name" value="{{ old('full_name', $children->full_name) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
    	<label for="date_of_birth">Date of Birth </label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($children->date_of_birth)->format('Y-m-d')) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group mb-0">
        <input type="submit" name="Save" class="btn btn-primary btn-sm btn-block">
        @if($id != 0)<a href="{{ route('Delete Child', ['id' => $id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>@endif
    </div>
</form>
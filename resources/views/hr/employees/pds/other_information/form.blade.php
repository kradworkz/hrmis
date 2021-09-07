<form action="{{ route('Submit Other Information', ['id' => $id]) }}" method="POST" autocomplete="off">
	{{ csrf_field() }}
	<input type="integer" min="1" name="employee_id" value="{{ $employee->id }}" hidden>
    <div class="form-group">
        <label for="skills">Special Skills and Hobbies</label>
        <input type="text" name="skills" value="{{ old('skills', $other_info->skills) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="recognition">Non-academic Distinction/Recognition</label>
        <input type="text" name="recognition" value="{{ old('recognition', $other_info->recognition) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="organization">Membership in Association/Organization</label>
        <input type="text" name="organization" value="{{ old('organization', $other_info->organization) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group mb-0">
	    <input type="submit" name="Save" class="btn btn-primary btn-sm btn-block">
        @if($id != 0)<a href="{{ route('Delete Other Information', ['id' => $id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>@endif
	</div>
</form>
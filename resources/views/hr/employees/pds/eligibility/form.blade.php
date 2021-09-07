<form action="{{ route('Submit Civil Service Eligibility', ['id' => $id]) }}" method="POST" autocomplete="off">
	{{ csrf_field() }}
    <input type="integer" min="1" name="employee_id" value="{{ $employee->id }}" hidden>
    <div class="form-group">
        <label for="eligibility_name">Career Service <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('eligibility_name') }}</i></label>
        <input type="text" name="eligibility_name" value="{{ old('eligibility_name', $eligibility->eligibility_name) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
        <label for="rating">Rating</label>
        <input type="text" name="rating" value="{{ old('rating', $eligibility->rating) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="date_of_examination">Date of Examination</label>
        <input type="date" name="date_of_examination" value="{{ old('date_of_examination', $eligibility->date_of_examination) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="place_of_examination">Place of Examination</label>
        <input type="text" name="place_of_examination" value="{{ old('place_of_examination', $eligibility->place_of_examination) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="eligibility_number">License Number</label>
        <input type="text" name="eligibility_number" value="{{ old('eligibility_number', $eligibility->eligibility_number) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="date_of_validity">Date of Validity</label>
        <input type="text" name="date_of_validity" value="{{ old('date_of_validity', $eligibility->date_of_validity) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group mb-0">
	    <input type="submit" name="Save" class="btn btn-primary btn-sm btn-block">
        @if($id != 0)<a href="{{ route('Delete Civil Service Eligibility', ['id' => $id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>@endif
	</div>
</form>
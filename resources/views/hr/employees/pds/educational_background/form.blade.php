<form action="{{ route('Submit Educational Background', ['id' => $id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <input type="integer" min="1" name="employee_id" value="{{ $employee->id }}" hidden>
    <div class="form-group">
		<label for="type">Level: <strong class="text-danger">*</strong></label>
		<select name="type" class="form-control form-control-sm">
			@foreach($levels as $key => $level)
				<option value="{{ $key }}" {{ old('type', $educational_background->type) == $key ? 'selected' : '' }}>{!! $level !!}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
        <label for="name_of_school">Name of School <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('name_of_school') }}</i></label>
        <input type="text" name="name_of_school" value="{{ old('name_of_school', $educational_background->name_of_school) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
        <label for="degree">Degree</label>
        <input type="text" name="degree" value="{{ old('degree', $educational_background->degree) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="period_from">From</label>
        <input type="date" name="period_from" value="{{ old('period_from', optional($educational_background->period_from)->format('Y-m-d')) }}" min="1950-01-01" max="{{ date('Y-m-d') }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="period_to">To</label>
        <input type="date" name="period_to" value="{{ old('period_to', optional($educational_background->period_to)->format('Y-m-d')) }}" min="1950-01-01" max="{{ date('Y-m-d') }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="units_earned">Highest Level/Units Earned</label>
        <input type="text" name="units_earned" value="{{ old('units_earned', $educational_background->units_earned) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="year_graduated">Year Graduated</label>
        <input type="number" min="1" name="year_graduated" value="{{ old('year_graduated', $educational_background->year_graduated) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="scholarship">Scholarship/Honors Received </label>
        <input type="text" name="scholarship" value="{{ old('scholarship', $educational_background->scholarship) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group mb-0">
	    <input type="submit" name="Save" class="btn btn-primary btn-sm btn-block">
        @if($id != 0)<a href="{{ route('Delete Educational Background', ['id' => $id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>@endif
	</div>
</form>
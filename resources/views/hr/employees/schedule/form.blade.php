<form action="{{ route('Submit Employee Schedule', ['id' => $schedule_id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <div class="form-group">
        <h6>Employee: <div><i class="text-primary">{!! $employee->full_name !!}</i></div></h6>
        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
    </div>
    <div class="form-group">
    	<label for="day">Day <span class="text-danger">*</span></label>
    	<select name="day" class="form-control form-control-sm" required>
    		@foreach($days as $key => $day)
    			<option value="{{ $key }}" {{ old('day', $schedule->day) == $key ? 'selected' : '' }}>{!! $day !!}</option>
    		@endforeach
    	</select>
    </div>
    <div class="form-group">
    	<label for="time_in">Time In <span class="text-danger">*</span></label>
    	<input type="time" name="time_in" value="{{ old('time_in', $schedule->time_in) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
    	<label for="time_out">Time Out <span class="text-danger">*</span></label>
    	<input type="time" name="time_out" value="{{ old('time_out', $schedule->time_out) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group mb-0">
	    <input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
	    @if($schedule_id != 0)
        <a href="{{ route('Delete Employee Schedule', ['id' => $schedule_id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>
        @endif
	</div>
</form>
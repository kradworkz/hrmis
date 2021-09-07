<form action="{{ route('Submit Employee Attendance', ['id' => $dtr_id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    @if($employee_id == 0)
        <div class="form-group">
            <label for="employee_id">Employee: <strong class="text-danger">*</strong></label>
            <select name="employee_id" class="form-control form-control-sm">
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ old('employee_id', $attendance->employee_id) == $employee->id ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
                @endforeach
            </select>
        </div>
    @else
        <div class="form-group mb-0">
            <label>Employee: <i class="text-primary font-weight-bold">{!! $employee->full_name !!}</i></label>
            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
        </div>
        <input type="hidden" id="date_ymd" name="date">
        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
    @endif
    @if($dtr_id == 0)
        <div class="form-group">
            <label for="date">Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('date') }}</i></label>
            <input type="date" name="date" value="{{ old('date', $attendance->time_in != null ? optional($attendance->time_in)->format('m/d/Y') : date('Y-m-d')) }}" class="form-control form-control-sm" required>
        </div>
    @else
    <input type="hidden" name="date" value="{{ old('date', $attendance->time_in->format('Y-m-d')) }}">
    <div class="form-group mb-0">
        <label>Date: <i class="text-primary font-weight-bold">{!! $attendance->time_in->format('F d, Y') !!}</i></label>
    </div>
    @endif
    <div class="form-group">
        <label>Time In</label>
        <input type="time" id="time_in" name="time_in" value="{{ old('time_in', optional($attendance->time_in)->format('H:i')) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
        <label>Time Out</label>
        <input type="time" id="time_out" name="time_out" value="{{ old('time_out', optional($attendance->time_out)->format('H:i')) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <div>Work Location</div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="location" id="home" value="0" {{ $attendance->location == 0 ? 'checked' : ''}}>
            <label class="form-check-label" for="home">Home</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="location" id="office" value="1" {{ $attendance->location == 1 ? 'checked' : ''}}>
            <label class="form-check-label" for="office">Office</label>
        </div>
    </div>
    <div class="form-group mb-0">
	    <input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
        @if($dtr_id != 0)<a href="{{ route('Delete Employee Attendance', ['id' => $attendance->id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>@endif
	</div>
</form>
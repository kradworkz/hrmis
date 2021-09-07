<form action="{{ route('Submit Employee Leave Credit', ['id' => $credit_id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <div class="form-group">
        <h6>Employee: <div><i class="text-primary">{!! $employee->full_name !!}</i></div></h6>
        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
    </div>
    <div class="form-group">
        <label for="particulars">Particulars </label>
        <input type="text" name="particulars" value="{{ old('particulars', $credit->particulars) }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <div>Particulars For</div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="particulars_for" id="None" value="" {{ $credit->particulars_for == '' ? 'checked' : ''}}>
            <abel class="form-check-label" for="None">None</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="particulars_for" id="VL" value="VL" {{ $credit->particulars_for == 'VL' ? 'checked' : ''}}>
            <abel class="form-check-label" for="VL">VL</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="particulars_for" id="SL" value="SL" {{ $credit->particulars_for == 'SL' ? 'checked' : ''}}>
            <label class="form-check-label" for="SL">SL</label>
        </div>
    </div>
    <div class="form-group">
        <label for="days">Day(s)</label>
        <input type="number" name="days" value="{{ old('days', $credit->days) == '' ? 0 : $credit->days }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="hours">Hour(s)</label>
        <input type="number" name="hours" min="0" max="8" value="{{ old('hours', $credit->hours) == '' ? 0 : $credit->hours }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="minutes">Minute(s)</label>
        <input type="number" name="minutes" min="0" max="60" value="{{ old('minutes', $credit->minutes) == '' ? 0 : $credit->minutes }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
    	<label for="vl_earned">Earned <i class="font-weight-bold text-success">(Vacation Leave)</i></label>
    	<input type="number" name="vl_earned" value="{{ old('vl_earned', $credit->vl_earned) }}" class="form-control form-control-sm" step="0.001">
    </div>
    <div class="form-group">
    	<label for="vl_deduct">Absence, Undertime w/ Pay <i class="font-weight-bold text-danger">(Vacation Leave)</i></label>
    	<input type="number" name="vl_deduct" value="{{ old('vl_deduct', $credit->vl_deduct) }}" class="form-control form-control-sm" step="0.001">
    </div>
    @if($credit_id != 0)
    <div class="form-group">
        <label for="vl_balance">Balance <i class="font-weight-bold text-primary">(Vacation Leave)</i></label>
        <input type="number" name="vl_balance" value="{{ old('vl_balance', $credit->vl_balance) }}" class="form-control form-control-sm" step="0.001">
    </div>
    @endif
    <div class="form-group">
        <label for="vl_deduct_without_pay">Absence, Undertime w/o Pay <i class="font-weight-bold text-danger">(Vacation Leave)</i></label>
        <input type="number" name="vl_deduct_without_pay" value="{{ old('vl_deduct_without_pay', $credit->vl_deduct_without_pay) }}" class="form-control form-control-sm" step="0.001">
    </div>
    <div class="form-group">
    	<label for="sl_earned">Earned <i class="font-weight-bold text-success">(Sick Leave)</i></label>
    	<input type="number" name="sl_earned" value="{{ old('sl_earned', $credit->sl_earned) }}" class="form-control form-control-sm" step="0.001">
    </div>
    <div class="form-group">
    	<label for="sl_deduct">Absence, Undertime w/ Pay <i class="font-weight-bold text-danger">(Sick Leave)</i></label>
    	<input type="number" name="sl_deduct" value="{{ old('sl_deduct', $credit->sl_deduct) }}" class="form-control form-control-sm" step="0.001">
    </div>
    @if($credit_id != 0)
    <div class="form-group">
        <label for="sl_balance">Balance <i class="font-weight-bold text-primary">(Sick Leave)</i></label>
        <input type="number" name="sl_balance" value="{{ old('sl_balance', $credit->sl_balance) }}" class="form-control form-control-sm" step="0.001">
    </div>
    @endif
    <div class="form-group">
        <label for="sl_deduct_without_pay">Absence, Undertime w/o Pay <i class="font-weight-bold text-danger">(Sick Leave)</i></label>
        <input type="number" name="sl_deduct_without_pay" value="{{ old('sl_deduct_without_pay', $credit->sl_deduct_without_pay) }}" class="form-control form-control-sm" step="0.001">
    </div>
    <div class="form-group">
        <label for="month">Month <span class="text-danger">*</span></label>
        <select name="month" class="form-control form-control-sm" required>
            @foreach($months as $key => $month)
                <option value="{{ $key }}" {{ old('month', $credit->month) == null ? (date('m') == $key ? 'selected' : '') : (old('month', $credit->month) == $key ? 'selected' : '') }}>{!! $month !!}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="year">Year <span class="text-danger">*</span></label>
        <select name="year" class="form-control form-control-sm" required>
            @foreach($years as $key => $year)
                <option value="{{ $key }}" {{ old('year', $credit->year) == null ? (date('Y') == $key ? 'selected' : '') : (old('year', $credit->year) == $key ? 'selected' : '') }}>{!! $year !!}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
    	<label for="remarks">Remarks</label>
    	<textarea name="remarks" class="form-control form-control-sm rounded-0"></textarea>
    </div>
    <div class="form-group mb-0">
	    <input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
        @if($credit->leave_id != NULL) <a href="{{ route('Print Leave', ['id' => $credit->leave_id]) }}" class="btn btn-sm btn-success btn-block rounded-0" target="_blank">Print</a> @endif
	    @if($credit_id != 0)<a href="{{ route('Delete Employee Leave Credit', ['id' => $credit->id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>@endif
	</div>
</form>
<form action="{{ route('Submit Employee COC', ['employee_id' => $employee->id, 'coc_id' => $coc_id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <div class="form-group">
        <h6>Employee: <div><i class="text-primary">{!! $employee->full_name !!}</i></div></h6>
        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
    </div>
    @if($coc->offset_id != null)
    <div class="form-group">
        <h6>Date of CTO: <div><i class="text-primary">{!! $coc->offset->date->format('F d, Y') !!}</i></div></h6>
    </div>
    <div class="form-group">
        <h6>Time: <div><i class="text-primary">{!! $coc->offset->time !!}</i></div></h6>
    </div>
    <div class="form-group">
        <h6>Remarks: <div><i class="text-primary">{!! $coc->offset->remarks !!}</i></div></h6>
    </div>
    @else
    <div class="form-group">
        <label for="beginning_hours">Hours <span class="text-danger">*</span></label>
        <input type="number" name="beginning_hours" value="{{ old('beginning_hours', $coc->beginning_hours) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
        <label for="beginning_minutes">Minutes <span class="text-danger">*</span></label>
        <input type="number" name="beginning_minutes" value="{{ old('beginning_minutes', $coc->beginning_minutes) }}" class="form-control form-control-sm" required>
    </div>
    <div class="form-group">
        <label for="month">Month <span class="text-danger">*</span></label>
        <select name="month" class="form-control form-control-sm" required>
            @foreach($months as $key => $month)
                <option value="{{ $key }}" {{ old('month', $coc->month) == null ? (date('m') == $key ? 'selected' : '') : (old('month', $coc->month) == $key ? 'selected' : '') }}>{!! $month !!}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="year">Year <span class="text-danger">*</span></label>
        <select name="year" class="form-control form-control-sm" required>
            @foreach($years as $key => $year)
                <option value="{{ $key }}" {{ old('year', $coc->year) == null ? (date('Y') == $key ? 'selected' : '') : (old('year', $coc->year) == $key ? 'selected' : '') }}>{!! $year !!}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <h6><i class="text-info">Type</i> </h6>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="type" value="1" {{ old('type', $coc->type == '1' ? 'checked' : '') }} class="custom-control-input" id="credit">
            <label class="custom-control-label" for="credit">Credit</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="type" value="0" {{ old('type', $coc->type == '0' ? 'checked' : '') }} class="custom-control-input" id="lapse">
            <label class="custom-control-label" for="lapse">Lapse</label>
        </div>
    </div>
    <div class="d-none" id="lapseContainer">
        <div class="form-group">
            <label for="lapse_month">Lapse Month <span class="text-danger">*</span></label>
            <select name="lapse_month" class="form-control form-control-sm" id="lapseMonth">
                @foreach($months as $key => $month)
                    <option value="{{ $key }}" {{ old('lapse_month', $coc->lapse_month) == null ? (date('m') == $key ? 'selected' : '') : (old('lapse_month', $coc->lapse_month) == $key ? 'selected' : '') }}>{!! $month !!}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="lapse_year">Lapse Year <span class="text-danger">*</span></label>
            <select name="lapse_year" class="form-control form-control-sm" id="lapseYear">
                @foreach($years as $key => $year)
                    <option value="{{ $key }}" {{ old('lapse_year', $coc->lapse_year) == null ? (date('Y') == $key ? 'selected' : '') : (old('lapse_year', $coc->lapse_year) == $key ? 'selected' : '') }}>{!! $year !!}</option>
                @endforeach
            </select>
        </div>  
    </div>
    
    @endif
    <div class="form-group mb-0">
	    @if($coc->offset_id == null)<input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">@endif
        <a href="{{ route('Delete Employee COC', ['id' => $coc->id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>
	</div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        $('.custom-control-input').click(function() {
            if($('#lapse').is(':checked')) {
                $('#lapseContainer').removeClass('d-none');
            }
            else {
                $('#lapseContainer').addClass('d-none');
            }
        });
    });
</script>
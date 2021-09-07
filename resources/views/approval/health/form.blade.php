<form action="{{ route('Submit Health Check Approval', ['id' => $id]) }}" method="POST" autocomplete="off">
	{{ csrf_field() }}
    <div class="form-group mb-0">
        <label>Employee: <i class="text-primary font-weight-bold">{!! $employee->employee->full_name !!}</i></label>
    </div>
    <div class="form-group mb-0">
    	<label>Symptoms:
            <span class="badge badge-primary">{{ $employee->fever }}</span> 
            <span class="badge badge-danger">{{ $employee->cough }}</span> 
            <span class="badge badge-info">{{ $employee->ache }}</span> 
            <span class="badge badge-secondary">{{ $employee->runny_nose }}</span> 
            <span class="badge badge-warning">{{ $employee->shortness_of_breath }}</span> 
            <span class="badge badge-success">{{ $employee->diarrhea }}</span>
        </label>
    </div>
    <div class="form-group mb-0">
        <label>Temperature: <i class="text-primary font-weight-bold">{!! $employee->temperature !!}</i></label>
    </div>
    <div class="form-group">
    	<label>Recommendations: </label>
    	<div class="custom-control custom-radio">
            <input type="radio" name="recommendation" value="14 days quarantine" class="custom-control-input" id="14dquarantine" required>
            <label class="custom-control-label" for="14dquarantine">14 days quarantine</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="recommendation" value="7 days quarantine" class="custom-control-input" id="7dquarantine" required>
            <label class="custom-control-label" for="7dquarantine">7 days quarantine</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="recommendation" value="Quarantine dates until cleared by residence MHO" class="custom-control-input" id="mho" required>
            <label class="custom-control-label" for="mho">Quarantine dates until cleared by residence MHO</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="recommendation" value="Continue reporting to office" class="custom-control-input" id="office" required>
            <label class="custom-control-label" for="office">Continue reporting to office</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="recommendation" value="Report to local health authorities" class="custom-control-input" id="report" required>
            <label class="custom-control-label" for="report">Report to local health authorities</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" name="recommendation" value="To monitor for signs and symptoms using the health monitoring form" class="custom-control-input" id="monitor" required>
            <label class="custom-control-label" for="monitor">To monitor for signs and symptoms using the health monitoring form</label>
        </div>
    </div>
    <div class="form-group">
        <label for="start_date">Start Date</label>
        <input type="date" name="start_date" min="1950-01-01" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="end_date">End Date</label>
        <input type="date" name="end_date" min="1950-01-01" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        <label for="remarks">Remarks</label>
        <textarea name="remarks" class="form-control form-control-sm rounded-0" rows="3"></textarea>
    </div>
    <div class="form-group">
    	<div class="custom-control custom-checkbox">
            <input type="checkbox" name="medical_certificate" value="1" class="custom-control-input" id="medical_certificate">
            <label class="custom-control-label" for="medical_certificate">Secure Medical Certificate</label>
        </div>
    </div>
    <div class="form-group pt-2 mb-1">
        <input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
        <a href="#" class="btn btn-sm btn-info btn-block rounded-0">Mark as Verified</a>
    </div>
</form>
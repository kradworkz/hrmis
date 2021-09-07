@if($signatory == 'leave_signatory')
    @if(Auth::user()->$signatory != NULL && Auth::user()->$signatory->signatory == 'Recommending' || Auth::user()->$signatory->signatory == 'Approval' || Auth::user()->$signatory->signatory == 'Chief HR')
        <div class="form-group">
            <label for="dates">Select Date(s) to Disapprove</label>
            <input type="date" name="date" class="form-control form-control-sm" value="" min="{{ $leave->start_date->format('Y-m-d') }}" max="{{ $leave->end_date->format('Y-m-d') }}" id="dates">
        </div>
        <div class="form-group">
            <label>Date(s) Selected: <span id="date_container"></span></label>
            <input type="hidden" name="dates" value="" id="leave_dates">
        </div>
    @endif
@endif
@if(Auth::user()->$signatory != NULL && Auth::user()->$signatory->signatory == 'Notification')
    <div class="form-group">
        <h6><i class="text-info">Action:</i> </h6>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="checked" value="0" {{ old('checked', $module->checked == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
            <label class="custom-control-label" for="pending">Pending</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="checked" value="1" {{ old('checked', $module->checked == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
            <label class="custom-control-label" for="approved">Approved</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="checked" value="2" {{ old('checked', $module->checked == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
            <label class="custom-control-label" for="disapproved">Disapproved</label>
        </div>
    </div>
@endif
@if(Auth::user()->$signatory != NULL && Auth::user()->$signatory->signatory == 'Human Resource')
    <div class="form-group">
        <h6><i class="text-info">Action:</i> </h6>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="verified" value="0" {{ old('verified', $module->verified == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
            <label class="custom-control-label" for="pending">Pending</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="verified" value="1" {{ old('verified', $module->verified == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
            <label class="custom-control-label" for="approved">Approved</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="verified" value="2" {{ old('verified', $module->verified == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
            <label class="custom-control-label" for="disapproved">Disapproved</label>
        </div>
    </div>
@endif
@if(Auth::user()->$signatory != NULL && Auth::user()->$signatory->signatory == 'Recommending')
    <div class="form-group">
        <h6><i class="text-info">Recommending:</i> </h6>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="recommending" value="0" {{ old('recommending', $module->recommending == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
            <label class="custom-control-label" for="pending">Pending</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="recommending" value="1" {{ old('recommending', $module->recommending == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
            <label class="custom-control-label" for="approved">Approved</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="recommending" value="2" {{ old('recommending', $module->recommending == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
            <label class="custom-control-label" for="disapproved">Disapproved</label>
        </div>
    </div>
    @if($signatory == 'leave_signatory')
        <div class="form-group">
            <label for="recommending_disapproval">Disapproval due to <i class="text-danger font-weight-bold">(for disapproved requests only)</i></label>
            <input type="text" name="recommending_disapproval" value="{{ old('recommending_disapproval', $module->recommending_disapproval) }}" id="recommending_disapproval" class="form-control form-control-sm">
        </div>
    @endif
@endif
@if(Auth::user()->$signatory != NULL && Auth::user()->$signatory->signatory == 'Approval')
    <div class="form-group">
        <h6><i class="text-info">Approval:</i> </h6>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="approval" value="0" {{ old('approval', $module->approval == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
            <label class="custom-control-label" for="pending">Pending</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="approval" value="1" {{ old('approval', $module->approval == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
            <label class="custom-control-label" for="approved">Approved</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" name="approval" value="2" {{ old('approval', $module->approval == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
            <label class="custom-control-label" for="disapproved">Disapproved</label>
        </div>
    </div>
    @if($signatory == 'leave_signatory')
        <div class="form-group">
            <h6 for="approval_disapproval"><small>Disapproval due to <i class="text-danger font-weight-bold">(for disapproved requests only)</i></small></h6>
            <input type="text" name="approval_disapproval" value="{{ old('approval_disapproval', $module->approval_disapproval) }}" id="approval_disapproval" class="form-control form-control-sm">
        </div>
    @endif
@endif
@if(Route::currentRouteName() == 'Edit Travel Approval' || Route::currentRouteName() == 'Edit Offset Approval' || Route::currentRouteName() == 'Edit Overtime Approval' || Route::currentRouteName() == 'Edit Leave Approval')
    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
    </div>
    <div class="form-group pt-2 mb-1">
        <input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
    </div>
    @include('layouts.modal_comment', ['comments' => $module])
@endif
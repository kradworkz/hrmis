<form action="{{ route('Submit DTR Approval', ['id' => $id]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    @if($id == 0)
        <div class="form-group">
            <label for="employee_id">Employee: <strong class="text-danger">*</strong></label>
            <select name="employee_id" class="form-control form-control-sm" required>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ old('employee_id', $dtr->employee_id) == $employee->id ? 'selected' : '' }}>{!! $employee->order_by_last_name !!}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="date">Date <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('date') }}</i></label>
            <input type="date" name="date" value="{{ old('date', optional($dtr->time_in)->format('m/d/Y')) }}" id="date" class="form-control form-control-sm" required>
        </div>
        <div class="form-group">
            <label>Time In <span class="text-danger">*</span> <i class="text-danger font-weight-bold">{{ $errors->first('time_in') }}</i></label>
            <input type="time" id="time_in" name="time_in" value="{{ old('time_in', optional($dtr->time_in)->format('h:i')) }}" class="form-control form-control-sm" required>
        </div>
        <div class="form-group">
            <label>Time Out</label>
            <input type="time" id="time_out" name="time_out" value="{{ old('time_out', optional($dtr->time_out)->format('h:i')) }}" class="form-control form-control-sm">
        </div>
        <div class="form-group mb-1">
            <input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
        </div>
    @else
        <div class="form-group mb-0">
            <label>Created By: <i class="text-primary font-weight-bold">{!! $dtr->employee->full_name !!}</i></label>
            <input type="hidden" name="employee_id" value="{{ $dtr->employee->id }}">
        </div>
        <div class="form-group mb-0">
            <label>Date: <i class="text-primary font-weight-bold">{!! $dtr->time_in->format('F d, Y') !!}</i></label>
            <input type="hidden" name="date" value="{{ $dtr->time_in->format('Y-m-d') }}">
        </div>
        <div class="form-group mb-0">
            <label>Time In: <i class="text-primary font-weight-bold">{!! $dtr->time_in->format('h:i A') !!}</i></label>
            <input type="hidden" name="time_in" value="{{ $dtr->time_in }}">
        </div>
        <div class="form-group mb-0">
            <label>Time Out: <i class="text-primary font-weight-bold">{!! $dtr->time_out->format('h:i A') !!}</i></label>
            <input type="hidden" name="time_out" value="{{ $dtr->time_out }}">
        </div>
        <div class="form-group mb-0">
            <label>Work Location: <i class="text-primary font-weight-bold">{!! $dtr->location == 1 ? 'Office' : 'Home' !!}</i></label>
            <input type="hidden" name="location" value="{{ $dtr->location }}">
        </div>
        <div class="form-group mb-0">
            <label>File Attachments:
                @foreach($dtr->attachments as $attachment)
                    <div><a class="text-decoration-none" href="{{ route('Get File Attachment', ['filename' => $attachment->filename]) }}" target="_blank"><i class="font-weight-bold">{!! $attachment->title !!}</i></a></div>
                @endforeach
            </label>
        </div>
        <div class="form-group">
            <h6><i class="text-info">Action:</i> </h6>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" name="status" value="0" {{ old('status', $dtr->status == '0' ? 'checked' : '') }} class="custom-control-input" id="pending">
                <label class="custom-control-label" for="pending">Pending</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" name="status" value="1" {{ old('status', $dtr->status == '1' ? 'checked' : '') }} class="custom-control-input" id="approved">
                <label class="custom-control-label" for="approved">Approved</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" name="status" value="2" {{ old('status', $dtr->status == '2' ? 'checked' : '') }} class="custom-control-input" id="disapproved">
                <label class="custom-control-label" for="disapproved">Disapproved</label>
            </div>
        </div>
        <div class="form-group">
            <label for="comment">Comment</label>
            <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
        </div>
        <div class="form-group pt-2 mb-1">
            <input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
            <a href="{{ route('Delete DTR Approval', ['id' => $dtr->id]) }}" class="btn btn-sm btn-danger btn-block rounded-0">Delete</a>
        </div>
        @include('layouts.modal_comment', ['comments' => $dtr])
    @endif
</form>
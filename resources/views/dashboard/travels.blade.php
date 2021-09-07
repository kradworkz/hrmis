<form action="{{ route('Submit Comment', ['id' => $id, 'module' => 2]) }}" method="POST" autocomplete="off">
    {{ csrf_field() }}
    <div class="form-group">
        <h6>Requested By: <div><i class="text-primary">{!! $travel->employee->full_name !!}</i></div></h6>
    </div>
    <div class="form-group">
        <h6>Date: <div><i class="text-primary">{!! $travel->reservation_dates !!} @if($travel->time != null) {!! $travel->time !!}@endif</i></div></h6>
    </div>
    <div class="form-group">
        <h6>Passengers: 
            @foreach($travel->travel_passengers as $passenger)
                <div><i class="text-primary">{!! $passenger->full_name !!}</i></div>
            @endforeach
        </h6>
    </div>
    <div class="form-group">
        <h6>Purpose: <div><i class="text-primary">{!! nl2br($travel->purpose) !!}</i></div></h6>
    </div>
    <div class="form-group">
        <h6>Destination: <div><i class="text-primary">{!! nl2br($travel->destination) !!}</i></div></h6>
    </div>
    @if($travel->remarks != null)
    <div class="form-group">
        <h6>Remarks: <div><i class="text-primary">{!! nl2br($travel->remarks) !!}</i></div></h6>
    </div>
    @endif
    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea name="comment" class="form-control form-control-sm rounded-0" rows="3"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" name="Submit" class="btn btn-sm btn-primary btn-block">
        <a href="#" data-dismiss="modal"  class="btn btn-sm btn-danger btn-block rounded-0">Cancel</a> 
    </div>
    @include('layouts.modal_comment', ['comments' => $travel])
</form>
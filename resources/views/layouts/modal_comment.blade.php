@if(count($comments->comments))
	<div class="modal-body">
	@foreach($comments->comments as $comment)
		<div class="row py-2">
			<div class="col-md-2 text-center">
				<div class="frame rounded-circle">
					<img src="{{ $comment->employee->picture == null ? asset('profile/default-profile.png') : asset('profile/'.$comment->employee->picture) }}" class="comment-image" width="100" height="100">
				</div>
			</div>
			<div class="col-md-10 d-flex flex-column">
				<div class="d-block w-100"><span class="text-primary font-weight-bold">{!! $comment->employee->full_name !!}</span> <a href="{{ route('Delete Comment', ['id' => $comment->id]) }}" class="float-right pr-2 {{ $comment->employee->id != Auth::id() ? 'd-none' : '' }}" data-toggle="tooltip" data-placement="top" title="Delete Comment"><i class="fa fa-comment-slash text-danger"></i></a></div>
				<p class="text-justify">{!! $comment->comment !!}</p>
				<div class="d-block mt-auto text-muted"><small>{!! getDateDiff($comment->updated_at) !!}</small></div>
			</div>
		</div>
		@if(!$loop->last)<hr>@endif
	@endforeach
	</div>
@endif
<?php

namespace hrmis\Http\Controllers;

use Session;
use hrmis\Models\Comment;
use hrmis\Http\Traits\CommentHelper;

class CommentController extends Controller
{
	use CommentHelper;
	public function submit($id, $module_id)
    {
        $this->submitComment($id, $module_id);
        $message = 'Comment successfully submitted.';
        return redirect()->back()->with('message', $message);
    }

	public function delete($id)
	{
		$comment = Comment::find($id);
		$comment->delete();
		return redirect()->back();
	}
}
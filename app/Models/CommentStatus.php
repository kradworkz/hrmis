<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class CommentStatus extends Model
{
    protected $table 	= 'comment_status';
    protected $fillable = ['is_read'];

    public function comment()
    {
    	return $this->hasOne('hrmis\Models\Comment', 'id', 'comment_id');
    }
}

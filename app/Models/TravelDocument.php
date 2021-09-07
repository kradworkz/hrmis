<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class TravelDocument extends Model
{
	protected $fillable = ['filename', 'title', 'document_path', 'travel_id'];

	public function travel_order()
	{
		return $this->belongsTo('hrmis\Models\Travel', 'travel_id', 'id');
	}
}
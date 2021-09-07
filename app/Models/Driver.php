<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
	use SoftDeletes;
    protected $fillable = ['name', 'is_active'];
}
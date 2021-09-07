<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeCredit extends Model
{
    protected $fillable 	= ['employee_id', 'hours', 'minutes', 'month', 'year', 'type', 'is_active'];
}
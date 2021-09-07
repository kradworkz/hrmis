<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class Eligibility extends Model
{
	protected $table 	= 'pds_eligibility';
    protected $fillable = ['employee_id', 'eligibility_name', 'rating', 'date_of_examination', 'place_of_examination', 'eligibility_number', 'date_of_validity'];
    protected $dates 	= ['date_of_examination'];

    public function employee()
	{
		return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
	}
}
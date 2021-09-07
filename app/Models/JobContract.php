<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobContract extends Model
{
	protected $table 		= 'contract_of_service';
	protected $fillable 	= ['employee_id', 'agency_head_name', 'agency_head_designation', 'employment_title', 'contract_duration', 'salary_rate', 
								'charging', 'duties_and_responsibilities', 'first_party_name', 'second_party_name', 'first_witness_name', 'first_witness_designation', 
								'second_witness_name', 'second_witness_designation', 'current_budget_officer_name', 'current_budget_officer_designation', 
								'current_accountant_name', 'current_accountant_designation', 'agency_head_id_name', 'agency_head_id_number', 'agency_head_id_date_issued', 
								'second_party_id_name', 'second_party_id_number', 'second_party_id_date_issued', 'is_active'];
	protected $dates = ['created_at'];

	public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }

    public function owner()
    {
    	return $this->belongsTo('hrmis\Models\Employee', 'employee_id', 'id');
    }

    public function scopeActive($query)
    {
    	return $query->where('is_active', '=', 1);
    }

    public function scopeYear($query, $year)
    {
    	return $query->whereYear('created_at', '=', $year);
    }
}
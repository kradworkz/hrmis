<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class TravelFundExpense extends Model
{
	protected $table 	  = 'travel_funds_expenses';
	protected $primaryKey = 'id';
	protected $fillable   = ['travel_id', 'expense_id', 'fund_id', 'others'];
}
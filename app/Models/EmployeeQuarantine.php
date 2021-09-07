<?php

namespace hrmis\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class EmployeeQuarantine extends Model
{
	protected $table    = 'employee_quarantine';
	protected $fillable = ['employee_health_check_id', 'employee_id', 'unit_id', 'start_date', 'end_date', 'recommendation', 'remarks', 'medical_certificate', 'monitor_health', 'report_local', 'endorsed_by', 'unit_head', 'unit_head_by', 'recommending_fas', 'recommending_fas_by', 'recommending_to', 'recommending_to_by', 'approval', 'approval_by', 'is_active', 'status'];
    protected $dates    = ['start_date', 'end_date'];

    public function getQuarantineDatesAttribute($value)
    {
        if($this->start_date != NULL && $this->end_date != NULL) {
            if($this->start_date == $this->end_date) {
                return $this->start_date->format('F d, Y');
            } 
            else {
                if($this->start_date->format('m') == $this->end_date->format('m')) {
                    return $this->start_date->format('F j')."-".$this->end_date->format('j, Y');
                }
                else {
                    return $this->start_date->format('F j, Y')."-".$this->end_date->format('F j, Y');
                }
            }
        }
    }

    public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'employee_id');
    }

    public function health_declaration()
    {
        return $this->hasOne('hrmis\Models\EmployeeHealthCheck', 'id', 'employee_health_check_id');
    }

    public function endorsed()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'endorsed_by');
    }

    public function comments()
    {
        return $this->hasMany('hrmis\Models\Comment', 'module', 'id')->where('module_id', '=', 7);
    }

    public function attachments()
    {
        return $this->hasMany('hrmis\Models\Attachment', 'module_id', 'id')->where('module_type', '=', 7);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeSignature($query, $status, $signatory = '')
    {
        if($signatory == 'Approval') {
            return $query->where(function($query) {
                $query->where('unit_head', '=', 1)->orWhere('recommending_fas', '=', 1)->orWhere('recommending_to', '=', 1);
            })->where('approval', '=', $status);
        }
        elseif($signatory == 'Recommending FAS') {
            return $query->where('recommending_fas', '=', $status);
        }
        elseif($signatory == 'Recommending') {
            return $query->where('recommending_to', '=', $status);
        }
        elseif($signatory == 'Unit Head') {
            return $query->where('unit_head', '=', $status);
        }
    }

    public function tagged_employees()
    {
        $quarantine     = collect([]);
        $quarantine[]   = $this->endorsed;
        $signatories    = getEmployeeSignatory(Auth::user()->unit_id, 7);
        $signatories    = $signatories->merge($quarantine);
        $signatories->map(function($item) {
            $item['route'] = 'View Employee Quarantine';
        });
        return $signatories;
    }
}
<?php

namespace hrmis\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable     = ['created_by', 'title', 'details', 'is_active', 'type', 'date', 'status'];
    protected $dates        = ['date'];
    
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d');
    }
    
    public function employee()
    {
        return $this->hasOne('hrmis\Models\Employee', 'id', 'created_by');
    }

    // FullCalendar Methods
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function isAllDay()
    {
        return true;
    }

    public function getStart()
    {
        return $this->date;
    }

    public function getEnd()
    {
        return Carbon::parse($this->date)->addDay();
    }

}
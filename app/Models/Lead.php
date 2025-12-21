<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
protected $fillable = [
    'name','email','phone','whatsapp','city','state','destination','address',

    'enquiry_for','status','travel_date','no_of_days','budget','comment',

    'no_of_person','no_of_child',

    'enquiry_date','follow_up_date','reference',
    'assigned_to','enquiry_suggestion_comment',

    'created_by'
];

    public function callLogs()
    {
        return $this->hasMany(CallLog::class);
    }

    public function editLogs()
    {
        return $this->hasMany(LeadEditLog::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function payments()
{
    return $this->hasMany(LeadPayment::class);
}

// Total paid
public function getTotalPaidAttribute()
{
    return $this->payments()->sum('amount');
}

// Balance amount (budget - paid)
public function getBalanceAmountAttribute()
{
    return max(($this->budget ?? 0) - $this->total_paid, 0);
}

public function dmcComments()
{
    return $this->hasMany(DmcComment::class);
}

public function dmcShares()
{
    return $this->hasMany(DmcLead::class);
}

public function dmc()
{
    return $this->belongsTo(Dmc::class);
}

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadPayment extends Model
{
    protected $fillable = [
        'lead_id',
        'amount',
        'type',
        'payment_date',
        'note',
        'added_by',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

public function addedBy()
{
    return $this->belongsTo(User::class, 'added_by');
}
}
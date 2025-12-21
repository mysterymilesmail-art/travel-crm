<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    protected $fillable = [
        'lead_id',
        'added_by',
        'call_summary',
        'next_follow_up_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
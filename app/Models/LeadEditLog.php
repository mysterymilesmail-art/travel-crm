<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadEditLog extends Model
{
    protected $fillable = [
        'lead_id',
        'edited_by',
        'field_name',
        'previous_value',
        'new_value',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
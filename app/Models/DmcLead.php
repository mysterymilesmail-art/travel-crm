<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DmcLead extends Model
{
    protected $fillable = [
        'lead_id',
        'dmc_id',
    ];

    /* =========================
       RELATIONSHIPS
       ========================= */

    // The lead/enquiry shared
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    // The DMC user
    public function dmc()
    {
        return $this->belongsTo(User::class, 'dmc_id');
    }
}
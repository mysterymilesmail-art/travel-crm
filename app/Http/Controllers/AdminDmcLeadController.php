<?php

namespace App\Http\Controllers;

use App\Models\DmcLead;
use Illuminate\Http\Request;

class AdminDmcLeadController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $dmcLeads = DmcLead::with([
            'lead',
            'lead.assignedAgent',
            'lead.dmcComments.user',
            'dmc'
        ])->latest()->get();

        return view('admin.dmc.leads', compact('dmcLeads'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
class DmcLeadController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'dmc') abort(403);

        $leads = Lead::whereHas('dmcShares', function ($q) {
            $q->where('dmc_id', auth()->id());
        })->get();

        return view('dmc.leads.index', compact('leads'));
    }

    public function show(Lead $lead)
    {
        if (auth()->user()->role !== 'dmc') abort(403);

        $allowed = $lead->dmcShares()
            ->where('dmc_id', auth()->id())
            ->exists();

        if (!$allowed) abort(403);

        $lead->load('dmcComments.user');

        return view('dmc.leads.show', compact('lead'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
class DmcLeadController extends Controller
{
public function index(Request $request)
{
    if (auth()->user()->role !== 'dmc') abort(403);

    $query = Lead::whereHas('dmcShares', function ($q) {
        $q->where('dmc_id', auth()->id());
    });

    // 🔍 SEARCH FILTER
    if ($request->filled('q')) {
        $search = $request->q;
        $query->where(function ($q) use ($search) {
            $q->where('destination', 'like', "%{$search}%")
              ->orWhere('city', 'like', "%{$search}%")
              ->orWhere('comment', 'like', "%{$search}%")
              ->orWhere('no_of_days', 'like', "%{$search}%")
              ->orWhere('no_of_person', 'like', "%{$search}%");
        });
    }

    $leads = $query->latest()->paginate(15)->withQueryString();

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

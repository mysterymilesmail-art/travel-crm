<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class CallLogController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $request->validate([
            'call_summary' => 'required',
            'next_follow_up_date' => 'nullable|date'
        ]);

        $lead->callLogs()->create([
            'added_by' => auth()->id(),
            'call_summary' => $request->call_summary,
            'next_follow_up_date' => $request->next_follow_up_date
        ]);

        return back()->with('success', 'Call log added successfully');
    }
}
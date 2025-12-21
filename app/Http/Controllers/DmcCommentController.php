<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DmcComment;
use App\Models\Lead;

class DmcCommentController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        if (!in_array(auth()->user()->role, ['admin','agent','dmc'])) {
            abort(403);
        }

        $request->validate(['message' => 'required']);

        DmcComment::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);

        return back();
    }
}

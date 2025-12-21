<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\SalesStage;
use App\Models\LeadEditLog;
use App\Models\DmcLead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $query = Lead::with('assignedAgent');

        // Agent sees only own or assigned leads
        if (auth()->user()->role === 'agent') {
            $query->where(function ($q) {
                $q->where('created_by', auth()->id())
                  ->orWhere('assigned_to', auth()->id());
            });
        }

        $leads = $query->latest()->paginate(15);
        return view('leads.index', compact('leads'));
    }

public function create()
{
    $agents = User::where('role', 'agent')->where('status', 1)->get();
    $stages = SalesStage::where('active', 1)->orderBy('order')->get();
    $dmcs   = User::where('role', 'dmc')->where('status', 1)->get();

    return view('leads.create', compact('agents','stages','dmcs'));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'whatsapp' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'destination' => 'nullable',
            'address' => 'nullable',

            'enquiry_for' => 'nullable',
            'status' => 'required',
            'travel_date' => 'nullable|date',
            'no_of_days' => 'nullable|numeric',
            'budget' => 'nullable|numeric',
            'comment' => 'nullable',

            'no_of_person' => 'nullable|numeric',
            'no_of_child' => 'nullable|numeric',

            'enquiry_date' => 'nullable|date',
            'follow_up_date' => 'nullable|date',
            'reference' => 'nullable',
            'assigned_to' => 'nullable|exists:users,id',
            'enquiry_suggestion_comment' => 'nullable',
        ]);

        $data['created_by'] = auth()->id();

        // Agent cannot assign
        if (auth()->user()->role !== 'admin') {
            $data['assigned_to'] = auth()->id();
        }

        Lead::create($data);

        return redirect()->route('leads.index')
            ->with('success', 'Lead created successfully');
    }

public function show(Lead $lead)
{
$lead->load([
    'payments.user',
    'callLogs.user',
    'editLogs.user',
    'assignedAgent',
    'dmcComments.user', // 🔥 REQUIRED
]);
    return view('leads.show', compact('lead'));
}

public function edit(Lead $lead)
{
    // Agents for assignment
    $agents = User::where('role', 'agent')
        ->where('status', 1)
        ->get();

    // Sales stages (DB driven)
    $stages = SalesStage::where('active', 1)
        ->orderBy('order')
        ->get();

    // DMC users (NEW)
    $dmcs = User::where('role', 'dmc')
        ->where('status', 1)
        ->get();

    return view('leads.edit', compact(
        'lead',
        'agents',
        'stages',
        'dmcs'
    ));
}


public function update(Request $request, Lead $lead)
{
    $old = $lead->getOriginal();

    $data = $request->validate([
        'name' => 'required',
        'email' => 'nullable|email',
        'phone' => 'nullable',
        'whatsapp' => 'nullable',
        'city' => 'nullable',
        'state' => 'nullable',
        'destination' => 'nullable',
        'address' => 'nullable',

        'enquiry_for' => 'nullable',
        'status' => 'required',
        'sales_stage' => 'nullable',
        'travel_date' => 'nullable|date',
        'no_of_days' => 'nullable|numeric',
        'budget' => 'nullable|numeric',
        'comment' => 'nullable',

        'no_of_person' => 'nullable|numeric',
        'no_of_child' => 'nullable|numeric',

        'enquiry_date' => 'nullable|date',
        'follow_up_date' => 'nullable|date',
        'reference' => 'nullable',
        'assigned_to' => 'nullable|exists:users,id',
        'enquiry_suggestion_comment' => 'nullable',

        // DMC (NOT part of leads table)
        'dmc_id' => 'nullable|exists:users,id',
    ]);

    // ❌ Agent cannot reassign lead
    if (auth()->user()->role !== 'admin') {
        unset($data['assigned_to']);
    }

    // ❌ Remove dmc_id before updating lead
    $dmcId = $data['dmc_id'] ?? null;
    unset($data['dmc_id']);

    // ✅ Update lead
    $lead->update($data);

    // ✅ SHARE LEAD WITH DMC (Admin / Agent only)
    if ($dmcId && in_array(auth()->user()->role, ['admin', 'agent'])) {
        DmcLead::firstOrCreate([
            'lead_id' => $lead->id,
            'dmc_id' => $dmcId,
        ]);
    }

    // ✅ STORE EDIT LOGS (INCLUDING SALES STAGE)
    foreach ($lead->getChanges() as $field => $newValue) {
        if ($field === 'updated_at') continue;

        LeadEditLog::create([
            'lead_id' => $lead->id,
            'edited_by' => auth()->id(),
            'field_name' => $field,
            'previous_value' => $old[$field] ?? null,
            'new_value' => $newValue,
        ]);
    }

    return redirect()
        ->route('leads.show', $lead)
        ->with('success', 'Lead updated successfully');
}
}
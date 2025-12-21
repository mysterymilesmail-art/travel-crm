<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadPayment;
use App\Models\LeadEditLog;
use Illuminate\Http\Request;

class LeadPaymentController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:Advance,Partial,Final',
            'payment_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $data['lead_id'] = $lead->id;
        $data['added_by'] = auth()->id();

        $payment = LeadPayment::create($data);

        /* =========================
           LOG PAYMENT ENTRY
        ========================= */
        LeadEditLog::create([
            'lead_id' => $lead->id,
            'edited_by' => auth()->id(),
            'field_name' => 'payment',
            'previous_value' => null,
            'new_value' => $payment->type . ' - ₹' . $payment->amount,
        ]);

        /* =========================
           AUTO UPDATE SALES STAGE
        ========================= */
        $oldStage = $lead->sales_stage;

        if ($payment->type === 'Advance') {
            $lead->update(['sales_stage' => 'Advance Payment Received']);
        }

        if ($payment->type === 'Final') {
            $lead->update(['sales_stage' => 'Full Payment Received']);
        }

        if ($oldStage !== $lead->sales_stage) {
            LeadEditLog::create([
                'lead_id' => $lead->id,
                'edited_by' => auth()->id(),
                'field_name' => 'sales_stage',
                'previous_value' => $oldStage,
                'new_value' => $lead->sales_stage,
            ]);
        }

        return back()->with('success', 'Payment recorded successfully');
    }
}
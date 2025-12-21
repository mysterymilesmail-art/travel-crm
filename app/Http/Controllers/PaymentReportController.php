<?php

namespace App\Http\Controllers;

use App\Models\LeadPayment;
use Illuminate\Http\Request;

class PaymentReportController extends Controller
{
    public function index(Request $request)
    {
        $query = LeadPayment::with(['lead', 'addedBy']);

        if (auth()->user()->role === 'agent') {
            $query->where('added_by', auth()->id());
        }

        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->to_date);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $payments = $query->latest('payment_date')->paginate(20);
        $totalAmount = (clone $query)->sum('amount');

        return view('reports.payment-report', compact('payments', 'totalAmount'));
    }
}
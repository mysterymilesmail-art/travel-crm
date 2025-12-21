<?php

namespace App\Http\Controllers;

use App\Models\CallLog;
use App\Models\LeadPayment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $query = CallLog::with(['lead.assignedAgent']);

        // Agent sees only their calls
        if (auth()->user()->role === 'agent') {
            $query->where('added_by', auth()->id());
        }

        // FOLLOWUPS
        $todayFollowups = (clone $query)
            ->whereDate('next_follow_up_date', $today)
            ->orderBy('next_follow_up_date')
            ->get();

        $upcomingFollowups = (clone $query)
            ->whereBetween('next_follow_up_date', [
                $today->copy()->addDay(),
                Carbon::today()->addDays(7)
            ])
            ->orderBy('next_follow_up_date')
            ->get();

        $overdueFollowups = (clone $query)
            ->whereDate('next_follow_up_date', '<', Carbon::today())
            ->orderBy('next_follow_up_date')
            ->get();

        // PAYMENTS (Dashboard Summary)
        $paymentQuery = LeadPayment::query();

        if (auth()->user()->role === 'agent') {
            $paymentQuery->where('added_by', auth()->id());
        }

        $totalPayments = (clone $paymentQuery)->sum('amount');

        $thisMonthPayments = (clone $paymentQuery)
            ->whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');

        $recentPayments = (clone $paymentQuery)
            ->with(['lead', 'addedBy'])
            ->latest('payment_date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'todayFollowups',
            'upcomingFollowups',
            'overdueFollowups',
            'totalPayments',
            'thisMonthPayments',
            'recentPayments'
        ));
    }
}
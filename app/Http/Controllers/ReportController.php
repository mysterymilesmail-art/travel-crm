<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 🔐 ADMIN ONLY ACCESS
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to   = $request->to ?? now()->toDateString();
        $agentId = $request->agent_id;

        /* ======================
           AGENT PERFORMANCE
        ====================== */
        $agentQuery = Lead::select(
                'assigned_to',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(status='Converted') as converted"),
                DB::raw("SUM(status='Lost') as lost"),
                DB::raw("SUM(status='In Progress') as in_progress")
            )
            ->whereBetween('enquiry_date', [$from, $to])
            ->groupBy('assigned_to');

        if ($agentId) {
            $agentQuery->where('assigned_to', $agentId);
        }

        $agentReport = $agentQuery->with('assignedAgent')->get();

        /* ======================
           DESTINATION REPORT
        ====================== */
        $destinationReport = Lead::select(
                'destination',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(status='Converted') as converted"),
                DB::raw("SUM(status='Lost') as lost")
            )
            ->whereNotNull('destination')
            ->whereBetween('enquiry_date', [$from, $to])
            ->groupBy('destination')
            ->orderByDesc('total')
            ->get();

        $agents = User::where('role', 'agent')->get();

        return view('reports.index', compact(
            'agentReport',
            'destinationReport',
            'agents',
            'from',
            'to',
            'agentId'
        ));
    }
}
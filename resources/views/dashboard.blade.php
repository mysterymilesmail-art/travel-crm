@extends('layouts.app')

@section('content')

{{-- ================= PAGE HEADER ================= --}}
<div class="mb-4">
    <h3 class="mb-0">Dashboard</h3>
    <small class="text-muted">
        Welcome back, {{ auth()->user()->name }}
    </small>
</div>

{{-- ================= ADMIN PAYMENT SUMMARY ================= --}}
@if(auth()->user()->role === 'admin')
<div class="row g-4 mb-4">

    <div class="col-md-6">
        <div class="card shadow-sm border-success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Payments</h6>
                        <h3 class="text-success mb-0">
                            ₹ {{ number_format($totalPayments, 2) }}
                        </h3>
                    </div>
                    <span class="badge bg-success fs-6">
                        All Time
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-primary h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">This Month Payments</h6>
                        <h3 class="text-primary mb-0">
                            ₹ {{ number_format($thisMonthPayments, 2) }}
                        </h3>
                    </div>
                    <span class="badge bg-primary fs-6">
                        {{ now()->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ================= RECENT PAYMENTS ================= --}}
<div class="card shadow-sm mb-5">
    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
        <span>Recent Payments</span>
        <a href="{{ route('reports.payments') }}"
           class="btn btn-sm btn-outline-primary">
            View Report
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Lead</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Added By</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPayments as $payment)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                    </td>
                    <td class="fw-semibold">
                        {{ $payment->lead->name ?? '-' }}
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $payment->type }}
                        </span>
                    </td>
                    <td>
                        ₹ {{ number_format($payment->amount, 2) }}
                    </td>
                    <td>
                        {{ $payment->addedBy->name ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">
                        No payments found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ================= FOLLOW UP DASHBOARD ================= --}}
<div class="mb-4">
    <h4 class="mb-0">Follow-Up Dashboard</h4>
    <small class="text-muted">
        Track today, upcoming & overdue follow-ups
    </small>
</div>

{{-- ================= TODAY ================= --}}
<div class="card shadow-sm mb-4 border-primary">
    <div class="card-header bg-primary text-white fw-bold">
        Today’s Follow-Ups
    </div>
    <div class="card-body p-0">
        @include('dashboard.followup-table', ['items' => $todayFollowups])
    </div>
</div>

{{-- ================= UPCOMING ================= --}}
<div class="card shadow-sm mb-4 border-success">
    <div class="card-header bg-success text-white fw-bold">
        Upcoming (Next 7 Days)
    </div>
    <div class="card-body p-0">
        @include('dashboard.followup-table', ['items' => $upcomingFollowups])
    </div>
</div>

{{-- ================= OVERDUE ================= --}}
<div class="card shadow-sm mb-4 border-danger">
    <div class="card-header bg-danger text-white fw-bold">
        Overdue Follow-Ups
    </div>
    <div class="card-body p-0">
        @include('dashboard.followup-table', ['items' => $overdueFollowups])
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')

<h3 class="mb-4">Dashboard</h3>
@if(auth()->user()->role === 'admin')
{{-- PAYMENT SUMMARY --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-body">
                <h6>Total Payments</h6>
                <h3 class="text-success">₹ {{ number_format($totalPayments, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-primary">
            <div class="card-body">
                <h6>This Month Payments</h6>
                <h3 class="text-primary">₹ {{ number_format($thisMonthPayments, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- RECENT PAYMENTS --}}
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        Recent Payments
        <a href="{{ route('reports.payments') }}" class="btn btn-sm btn-light float-end">
            View Report
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead>
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
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->lead->name ?? '-' }}</td>
                    <td>
                        <span class="badge bg-info">{{ $payment->type }}</span>
                    </td>
                    <td>₹ {{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->addedBy->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No payments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

<h3 class="mb-4">Follow-Up Dashboard</h3>

{{-- TODAY --}}
<div class="card mb-4 border-primary">
    <div class="card-header bg-primary text-white">
        Today’s Follow-Ups
    </div>
    <div class="card-body p-0">
        @include('dashboard.followup-table', ['items' => $todayFollowups])
    </div>
</div>

{{-- UPCOMING --}}
<div class="card mb-4 border-success">
    <div class="card-header bg-success text-white">
        Upcoming (Next 7 Days)
    </div>
    <div class="card-body p-0">
        @include('dashboard.followup-table', ['items' => $upcomingFollowups])
    </div>
</div>

{{-- OVERDUE --}}
<div class="card mb-4 border-danger">
    <div class="card-header bg-danger text-white">
        Overdue Follow-Ups
    </div>
    <div class="card-body p-0">
        @include('dashboard.followup-table', ['items' => $overdueFollowups])
    </div>
</div>

@endsection
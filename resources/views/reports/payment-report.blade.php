@extends('layouts.app')

@section('content')

<h3 class="mb-4">Payment Report</h3>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
    </div>

    <div class="col-md-3">
        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
    </div>

    <div class="col-md-3">
        <select name="type" class="form-control">
            <option value="">All Types</option>
            <option value="Advance" @selected(request('type')=='Advance')>Advance</option>
            <option value="Partial" @selected(request('type')=='Partial')>Partial</option>
            <option value="Final" @selected(request('type')=='Final')>Final</option>
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<div class="mb-3">
    <h5>Total Amount: ₹ {{ number_format($totalAmount, 2) }}</h5>
</div>

<table class="table table-bordered">
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
        @forelse($payments as $payment)
        <tr>
            <td>{{ $payment->payment_date }}</td>
            <td>{{ $payment->lead->name ?? '-' }}</td>
            <td>{{ $payment->type }}</td>
            <td>₹ {{ number_format($payment->amount, 2) }}</td>
            <td>{{ $payment->addedBy->name ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No records found</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $payments->links() }}

@endsection
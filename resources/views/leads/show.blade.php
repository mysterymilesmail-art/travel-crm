@extends('layouts.app')
@section('content')

<h4 class="mb-3">
    {{ $lead->name }}
    <span class="badge bg-secondary ms-2">
        {{ $lead->sales_stage ?? 'Enquiry' }}
    </span>
</h4>

{{-- ================= CUSTOMER DETAILS ================= --}}
<h5 class="mt-3">Customer Details</h5>
<table class="table table-sm table-bordered">
<tr><th>Email</th><td>{{ $lead->email }}</td></tr>
<tr><th>Mobile</th><td>{{ $lead->phone }}</td></tr>
<tr><th>WhatsApp</th><td>{{ $lead->whatsapp }}</td></tr>
<tr><th>City</th><td>{{ $lead->city }}</td></tr>
<tr><th>State</th><td>{{ $lead->state }}</td></tr>
<tr><th>Destination</th><td>{{ $lead->destination }}</td></tr>
<tr><th>Address</th><td>{{ $lead->address }}</td></tr>
</table>

{{-- ================= REQUIREMENT ================= --}}
<h5>Requirement</h5>
<table class="table table-sm table-bordered">
<tr><th>Enquiry For</th><td>{{ $lead->enquiry_for }}</td></tr>
<tr><th>Status</th><td>{{ $lead->status }}</td></tr>
<tr><th>Travel Date</th><td>{{ $lead->travel_date }}</td></tr>
<tr><th>No of Days</th><td>{{ $lead->no_of_days }}</td></tr>
<tr>
    <th>Budget</th>
    <td>₹ {{ number_format($lead->budget ?? 0, 2) }}</td>
</tr>
<tr><th>Comment</th><td>{{ $lead->comment }}</td></tr>
</table>

{{-- ================= PAX INFO ================= --}}
<h5>Pax Info</h5>
<table class="table table-sm table-bordered">
<tr><th>No of Persons</th><td>{{ $lead->no_of_person }}</td></tr>
<tr><th>No of Children</th><td>{{ $lead->no_of_child }}</td></tr>
</table>

{{-- ================= TEAM INFO ================= --}}
<h5>Team Info</h5>
<table class="table table-sm table-bordered">
<tr><th>Enquiry Date</th><td>{{ $lead->enquiry_date }}</td></tr>
<tr><th>Follow Up Date</th><td>{{ $lead->follow_up_date }}</td></tr>
<tr><th>Reference</th><td>{{ $lead->reference }}</td></tr>
<tr><th>Assigned To</th><td>{{ $lead->assignedAgent->name ?? 'Unassigned' }}</td></tr>
<tr><th>Suggestion</th><td>{{ $lead->enquiry_suggestion_comment }}</td></tr>
</table>

<hr>

{{-- ================= PAYMENTS ================= --}}
<h5>Payments</h5>

<table class="table table-bordered table-sm mb-3">
<tr>
    <th>Total Budget</th>
    <td>₹ {{ number_format($lead->budget ?? 0, 2) }}</td>
</tr>
<tr>
    <th>Total Paid</th>
    <td class="text-success">₹ {{ number_format($lead->total_paid, 2) }}</td>
</tr>
<tr>
    <th>Balance Amount</th>
    <td class="text-danger">₹ {{ number_format($lead->balance_amount, 2) }}</td>
</tr>
</table>

@if($lead->status === 'Converted')
<form method="POST" action="{{ route('payments.store', $lead) }}" class="mb-4">
@csrf
<div class="row">
    <div class="col-md-3">
        <label>Amount</label>
        <input type="number" name="amount" class="form-control" required>
    </div>
    <div class="col-md-3">
        <label>Payment Type</label>
        <select name="type" class="form-control">
            <option>Advance</option>
            <option>Partial</option>
            <option>Final</option>
        </select>
    </div>
    <div class="col-md-3">
        <label>Payment Date</label>
        <input type="date" name="payment_date" class="form-control" required>
    </div>
    <div class="col-md-3">
        <label>Note</label>
        <input type="text" name="note" class="form-control">
    </div>
</div>
<button class="btn btn-success btn-sm mt-2">Add Payment</button>
</form>
@endif

<table class="table table-bordered table-sm">
<tr>
    <th>Date</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Added By</th>
    <th>Note</th>
</tr>
@forelse($lead->payments as $payment)
<tr>
    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
    <td>{{ $payment->type }}</td>
    <td>₹ {{ number_format($payment->amount, 2) }}</td>
    <td>{{ $payment->user->name ?? '-' }}</td>
    <td>{{ $payment->note }}</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted">No payments recorded</td></tr>
@endforelse
</table>

<hr>

{{-- ================= DMC DISCUSSION ================= --}}
<h5>DMC Discussion</h5>

<div class="mb-3">
@forelse($lead->dmcComments as $comment)
    <div class="border rounded p-2 mb-2
        {{ $comment->user->role === 'dmc' ? 'bg-light' : 'bg-white' }}">
        
        <strong>
            {{ $comment->user->name }}
            <span class="badge bg-secondary ms-1">
                {{ strtoupper($comment->user->role) }}
            </span>
        </strong>

        <small class="text-muted float-end">
            {{ $comment->created_at->format('d M Y H:i') }}
        </small>

        <p class="mb-0 mt-1">{{ $comment->message }}</p>
    </div>
@empty
    <p class="text-muted">No discussion with DMC yet.</p>
@endforelse
</div>

@if(in_array(auth()->user()->role, ['admin','agent']))
<form method="POST" action="{{ route('dmc.comment.store', $lead) }}">
@csrf
    <label class="form-label">Send message to DMC</label>
    <textarea name="message" class="form-control mb-2"
              rows="3"
              placeholder="Write message for DMC..."
              required></textarea>
    <button class="btn btn-primary btn-sm">Send to DMC</button>
</form>
@endif

<hr>

{{-- ================= CALL LOGS ================= --}}
@include('leads.partials.call-logs')

{{-- ================= EDIT HISTORY ================= --}}
@include('leads.partials.edit-logs')

@endsection
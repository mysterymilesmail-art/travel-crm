@extends('layouts.app')
@section('content')

{{-- ================= HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    {{-- LEFT : BACK --}}
    <div>
        <a href="{{ route('leads.index') }}"
           class="btn btn-outline-secondary btn-sm mb-1">
            ← Back to Leads
        </a>

        <h4 class="mb-0">{{ $lead->name }}</h4>

        <small class="text-muted">
            Destination: {{ $lead->destination ?? '—' }}
        </small>
    </div>

    {{-- RIGHT : ACTIONS --}}
    <div class="text-end">
        <span class="badge bg-secondary fs-6 d-block mb-2">
            {{ $lead->sales_stage ?? 'Enquiry' }}
        </span>

        @if(in_array(auth()->user()->role, ['admin','agent']))
            <a href="{{ route('leads.edit', $lead) }}"
               class="btn btn-warning btn-sm">
                ✏️ Edit Lead
            </a>
        @endif
    </div>

</div>
<div class="row g-4">

{{-- ================= LEFT COLUMN ================= --}}
<div class="col-md-8">

    {{-- CUSTOMER DETAILS --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Customer Details</div>
        <div class="card-body row">
            <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $lead->email ?? '—' }}</div>
            <div class="col-md-6 mb-2"><strong>Mobile:</strong> {{ $lead->phone ?? '—' }}</div>
            <div class="col-md-6 mb-2"><strong>WhatsApp:</strong> {{ $lead->whatsapp ?? '—' }}</div>
            <div class="col-md-6 mb-2"><strong>City:</strong> {{ $lead->city ?? '—' }}</div>
            <div class="col-md-6 mb-2"><strong>State:</strong> {{ $lead->state ?? '—' }}</div>
            <div class="col-md-6 mb-2"><strong>Address:</strong> {{ $lead->address ?? '—' }}</div>
        </div>
    </div>

    {{-- REQUIREMENT --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Requirement</div>
        <div class="card-body row">
            <div class="col-md-6 mb-2"><strong>Enquiry For:</strong> {{ $lead->enquiry_for ?? '—' }}</div>
            <div class="col-md-6 mb-2">
                <strong>Status:</strong>
                <span class="badge bg-info">{{ $lead->status }}</span>
            </div>
            <div class="col-md-6 mb-2"><strong>Travel Date:</strong> {{ $lead->travel_date ?? '—' }}</div>
            <div class="col-md-6 mb-2"><strong>No. of Days:</strong> {{ $lead->no_of_days ?? '—' }}</div>
            <div class="col-md-6 mb-2"><strong>Budget:</strong> ₹ {{ number_format($lead->budget ?? 0,2) }}</div>
            <div class="col-md-12"><strong>Comment:</strong><br>{{ $lead->comment ?? '—' }}</div>
        </div>
    </div>

    {{-- PAX INFO --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Pax Information</div>
        <div class="card-body row">
            <div class="col-md-6"><strong>Adults:</strong> {{ $lead->no_of_person ?? 0 }}</div>
            <div class="col-md-6"><strong>Children:</strong> {{ $lead->no_of_child ?? 0 }}</div>
        </div>
    </div>

    {{-- DMC DISCUSSION --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">DMC Discussion</div>
        <div class="card-body">

            @forelse($lead->dmcComments as $comment)
                <div class="border rounded p-2 mb-2
                    {{ $comment->user->role === 'dmc' ? 'bg-light' : 'bg-white' }}">
                    <div class="d-flex justify-content-between">
                        <strong>
                            {{ $comment->user->name }}
                            <span class="badge bg-secondary ms-1">
                                {{ strtoupper($comment->user->role) }}
                            </span>
                        </strong>
                        <small class="text-muted">
                            {{ $comment->created_at->format('d M Y H:i') }}
                        </small>
                    </div>
                    <div class="mt-1">{{ $comment->message }}</div>
                </div>
            @empty
                <p class="text-muted mb-0">No discussion yet.</p>
            @endforelse

            @if(in_array(auth()->user()->role, ['admin','agent']))
            <form method="POST" action="{{ route('dmc.comment.store', $lead) }}" class="mt-3">
                @csrf
                <textarea name="message" class="form-control mb-2"
                          rows="3"
                          placeholder="Write message for DMC..."
                          required></textarea>
                <button class="btn btn-primary btn-sm">Send to DMC</button>
            </form>
            @endif
        </div>
    </div>

    {{-- CALL LOGS --}}
    @include('leads.partials.call-logs')

    {{-- EDIT HISTORY --}}
    @include('leads.partials.edit-logs')

</div>

{{-- ================= RIGHT COLUMN ================= --}}
<div class="col-md-4">

    {{-- TEAM INFO --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Team Info</div>
        <div class="card-body">
            <p><strong>Enquiry Date:</strong> {{ $lead->enquiry_date ?? '—' }}</p>
            <p><strong>Follow Up:</strong> {{ $lead->follow_up_date ?? '—' }}</p>
            <p><strong>Reference:</strong> {{ $lead->reference ?? '—' }}</p>
            <p><strong>Assigned To:</strong> {{ $lead->assignedAgent->name ?? 'Unassigned' }}</p>
            <p><strong>Suggestion:</strong><br>{{ $lead->enquiry_suggestion_comment ?? '—' }}</p>
        </div>
    </div>

    {{-- PAYMENTS --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Payments Summary</div>
        <div class="card-body">
            <p><strong>Total Budget:</strong> ₹ {{ number_format($lead->budget ?? 0,2) }}</p>
            <p class="text-success"><strong>Total Paid:</strong> ₹ {{ number_format($lead->total_paid,2) }}</p>
            <p class="text-danger"><strong>Balance:</strong> ₹ {{ number_format($lead->balance_amount,2) }}</p>
        </div>
    </div>

</div>

</div>

@endsection
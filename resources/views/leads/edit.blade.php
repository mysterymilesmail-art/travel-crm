@extends('layouts.app')
@section('content')

{{-- ================= HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('leads.show', $lead) }}"
           class="btn btn-outline-secondary btn-sm mb-1">
            ← Back to Lead
        </a>
        <h4 class="mb-0">Edit Lead</h4>
        <small class="text-muted">{{ $lead->name }}</small>
    </div>

    <span class="badge bg-secondary fs-6">
        {{ $lead->sales_stage ?? 'Enquiry' }}
    </span>
</div>

<form method="POST" action="{{ route('leads.update', $lead) }}">
@csrf
@method('PUT')

<div class="row g-4">

{{-- ================= LEFT COLUMN ================= --}}
<div class="col-md-8">

    {{-- CUSTOMER DETAILS --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Customer Details</div>
        <div class="card-body row">
            <div class="col-md-4 mb-2">
                <label>Name</label>
                <input name="name" class="form-control" value="{{ $lead->name }}" required>
            </div>

            <div class="col-md-4 mb-2">
                <label>Email</label>
                <input name="email" class="form-control" value="{{ $lead->email }}">
            </div>

            <div class="col-md-4 mb-2">
                <label>Mobile</label>
                <input name="phone" class="form-control" value="{{ $lead->phone }}">
            </div>

            <div class="col-md-4 mb-2">
                <label>WhatsApp</label>
                <input name="whatsapp" class="form-control" value="{{ $lead->whatsapp }}">
            </div>

            <div class="col-md-4 mb-2">
                <label>City</label>
                <input name="city" class="form-control" value="{{ $lead->city }}">
            </div>

            <div class="col-md-4 mb-2">
                <label>State</label>
                <input name="state" class="form-control" value="{{ $lead->state }}">
            </div>

            <div class="col-md-6 mb-2">
                <label>Travel Destination</label>
                <input name="destination" class="form-control"
                       value="{{ $lead->destination }}">
            </div>

            <div class="col-md-12">
                <label>Address</label>
                <textarea name="address" class="form-control"
                          rows="2">{{ $lead->address }}</textarea>
            </div>
        </div>
    </div>

    {{-- REQUIREMENT --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Requirement</div>
        <div class="card-body row">
            <div class="col-md-4 mb-2">
                <label>Enquiry For</label>
                <select name="enquiry_for" class="form-control">
                    @foreach(['Package','Hotel','Flight','Visa','Train','Group Departure'] as $opt)
                        <option {{ $lead->enquiry_for==$opt?'selected':'' }}>
                            {{ $opt }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    @foreach(['New','In Progress','Converted','Lost'] as $st)
                        <option {{ $lead->status==$st?'selected':'' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-2">
                <label>Travel Date</label>
                <input type="date" name="travel_date"
                       class="form-control"
                       value="{{ $lead->travel_date }}">
            </div>

            <div class="col-md-4 mb-2">
                <label>No of Days</label>
                <input type="number" name="no_of_days"
                       class="form-control"
                       value="{{ $lead->no_of_days }}">
            </div>

            <div class="col-md-4 mb-2">
                <label>Budget</label>
                <input type="number" name="budget"
                       class="form-control"
                       value="{{ $lead->budget }}">
            </div>

            <div class="col-md-12">
                <label>Comment</label>
                <textarea name="comment" class="form-control"
                          rows="2">{{ $lead->comment }}</textarea>
            </div>
        </div>
    </div>

    {{-- PAX INFO --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Pax Information</div>
        <div class="card-body row">
            <div class="col-md-4">
                <label>Adults</label>
                <input type="number" name="no_of_person"
                       class="form-control"
                       value="{{ $lead->no_of_person }}">
            </div>

            <div class="col-md-4">
                <label>Children</label>
                <input type="number" name="no_of_child"
                       class="form-control"
                       value="{{ $lead->no_of_child }}">
            </div>
        </div>
    </div>

</div>

{{-- ================= RIGHT COLUMN ================= --}}
<div class="col-md-4">

    {{-- TEAM INFO --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">Team Info</div>
        <div class="card-body">
            <label>Enquiry Date</label>
            <input type="date" name="enquiry_date"
                   class="form-control mb-2"
                   value="{{ $lead->enquiry_date }}">

            <label>Follow Up Date</label>
            <input type="date" name="follow_up_date"
                   class="form-control mb-2"
                   value="{{ $lead->follow_up_date }}">

            <label>Reference</label>
            <select name="reference" class="form-control mb-2">
                @foreach(['Advertise','Customer Reference','Social Media','Telephone','Website'] as $ref)
                    <option {{ $lead->reference==$ref?'selected':'' }}>
                        {{ $ref }}
                    </option>
                @endforeach
            </select>

            @if(auth()->user()->role === 'admin')
                <label>Allocate To</label>
                <select name="assigned_to" class="form-control mb-2">
                    <option value="">-- Unassigned --</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}"
                            {{ $lead->assigned_to==$agent->id?'selected':'' }}>
                            {{ $agent->name }}
                        </option>
                    @endforeach
                </select>
            @endif

            <label>Sales Stage</label>
            <select name="sales_stage" class="form-control mb-2">
                @foreach($stages as $stage)
                    <option value="{{ $stage->name }}"
                        {{ $lead->sales_stage === $stage->name ? 'selected' : '' }}>
                        {{ $stage->name }}
                    </option>
                @endforeach
            </select>

            <label>Enquiry Suggestion</label>
            <textarea name="enquiry_suggestion_comment"
                      class="form-control"
                      rows="2">{{ $lead->enquiry_suggestion_comment }}</textarea>
        </div>
    </div>

    {{-- DMC SHARE --}}
    @if(auth()->user()->role !== 'dmc')
    <div class="card mb-4">
        <div class="card-header fw-bold">DMC Sharing</div>
        <div class="card-body">
            <label>Share with DMC</label>
            <select name="dmc_id" class="form-control">
                <option value="">-- Select DMC --</option>
                @foreach($dmcs as $dmc)
                    <option value="{{ $dmc->id }}">{{ $dmc->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif

</div>

</div>

{{-- ================= ACTIONS ================= --}}
<div class="mt-3">
    <button class="btn btn-success">💾 Update Lead</button>
    <a href="{{ route('leads.show', $lead) }}"
       class="btn btn-outline-secondary ms-2">
        Cancel
    </a>
</div>

</form>
@endsection
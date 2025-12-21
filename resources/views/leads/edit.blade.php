@extends('layouts.app')
@section('content')

<form method="POST" action="{{ route('leads.update', $lead) }}">
@csrf
@method('PUT')

{{-- CUSTOMER DETAILS --}}
<h5 class="mb-2">Customer Details</h5>
<div class="row">
    <div class="col-md-4">
        <label>Name</label>
        <input name="name" class="form-control mb-2" value="{{ $lead->name }}" required>
    </div>

    <div class="col-md-4">
        <label>Email</label>
        <input name="email" class="form-control mb-2" value="{{ $lead->email }}">
    </div>

    <div class="col-md-4">
        <label>Mobile</label>
        <input name="phone" class="form-control mb-2" value="{{ $lead->phone }}">
    </div>

    <div class="col-md-4">
        <label>WhatsApp</label>
        <input name="whatsapp" class="form-control mb-2" value="{{ $lead->whatsapp }}">
    </div>

    <div class="col-md-4">
        <label>City</label>
        <input name="city" class="form-control mb-2" value="{{ $lead->city }}">
    </div>

    <div class="col-md-4">
        <label>State</label>
        <input name="state" class="form-control mb-2" value="{{ $lead->state }}">
    </div>

    <div class="col-md-4">
        <label>Travel Destination / Location</label>
        <input name="destination" class="form-control mb-2"
               value="{{ $lead->destination }}"
               placeholder="Eg: Dubai, Bali, Paris">
    </div>

    <div class="col-md-12">
        <label>Address</label>
        <textarea name="address" class="form-control mb-3">{{ $lead->address }}</textarea>
    </div>
</div>

{{-- REQUIREMENT --}}
<h5 class="mb-2">Requirement</h5>
<div class="row">
    <div class="col-md-4">
        <label>Enquiry For</label>
        <select name="enquiry_for" class="form-control mb-2">
            @foreach(['Package','Hotel','Flight','Visa','Train','Group Departure'] as $opt)
                <option {{ $lead->enquiry_for==$opt?'selected':'' }}>{{ $opt }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label>Status</label>
        <select name="status" class="form-control mb-2">
            @foreach(['New','In Progress','Converted','Lost'] as $st)
                <option {{ $lead->status==$st?'selected':'' }}>{{ $st }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label>Travel Date</label>
        <input type="date" name="travel_date" class="form-control mb-2"
               value="{{ $lead->travel_date }}">
    </div>

    <div class="col-md-4">
        <label>No of Days</label>
        <input type="number" name="no_of_days" class="form-control mb-2"
               value="{{ $lead->no_of_days }}">
    </div>

    <div class="col-md-4">
        <label>Budget</label>
        <input type="number" name="budget" class="form-control mb-2"
               value="{{ $lead->budget }}">
    </div>

    <div class="col-md-12">
        <label>Comment</label>
        <textarea name="comment" class="form-control mb-3">{{ $lead->comment }}</textarea>
    </div>
</div>

{{-- PAX INFO --}}
<h5 class="mb-2">Pax Info</h5>
<div class="row">
    <div class="col-md-4">
        <label>No of Persons</label>
        <input type="number" name="no_of_person" class="form-control mb-2"
               value="{{ $lead->no_of_person }}">
    </div>

    <div class="col-md-4">
        <label>No of Children</label>
        <input type="number" name="no_of_child" class="form-control mb-3"
               value="{{ $lead->no_of_child }}">
    </div>
</div>

{{-- TEAM INFO --}}
<h5 class="mb-2">Team Info</h5>
<div class="row">
    <div class="col-md-4">
        <label>Enquiry Date</label>
        <input type="date" name="enquiry_date" class="form-control mb-2"
               value="{{ $lead->enquiry_date }}">
    </div>

    <div class="col-md-4">
        <label>Follow Up Date</label>
        <input type="date" name="follow_up_date" class="form-control mb-2"
               value="{{ $lead->follow_up_date }}">
    </div>

    <div class="col-md-4">
        <label>Reference</label>
        <select name="reference" class="form-control mb-2">
            @foreach(['Advertise','Customer Reference','Social Media','Telephone','Website'] as $ref)
                <option {{ $lead->reference==$ref?'selected':'' }}>{{ $ref }}</option>
            @endforeach
        </select>
    </div>

    @if(auth()->user()->role === 'admin')
    <div class="col-md-4">
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
    </div>
    @endif

    <div class="col-md-12">
        <label>Enquiry Suggestion Comment</label>
        <textarea name="enquiry_suggestion_comment" class="form-control mb-3">
            {{ $lead->enquiry_suggestion_comment }}
        </textarea>
    </div>

    <label>Sales Stage</label>
<select name="sales_stage" class="form-control mb-2">
    @foreach($stages as $stage)
        <option value="{{ $stage->name }}"
            {{ $lead->sales_stage === $stage->name ? 'selected' : '' }}>
            {{ $stage->name }}
        </option>
    @endforeach
</select>
</div>
@if(auth()->user()->role !== 'dmc')
<label>Share with DMC</label>
<select name="dmc_id" class="form-control mb-2">
    <option value="">-- Select DMC --</option>
    @foreach($dmcs as $dmc)
        <option value="{{ $dmc->id }}">{{ $dmc->name }}</option>
    @endforeach
</select>
@endif
<button class="btn btn-primary">Update Lead</button>

</form>

@endsection
@extends('layouts.app')
@section('content')

<form method="POST" action="{{ route('leads.store') }}">
@csrf

{{-- CUSTOMER DETAILS --}}
<h5 class="mb-2">Customer Details</h5>
<div class="row">
    <div class="col-md-4">
        <label>Name</label>
        <input name="name" class="form-control mb-2" required>
    </div>
    <div class="col-md-4">
        <label>Email</label>
        <input name="email" class="form-control mb-2">
    </div>
    <div class="col-md-4">
        <label>Mobile</label>
        <input name="phone" class="form-control mb-2">
    </div>
    <div class="col-md-4">
        <label>WhatsApp</label>
        <input name="whatsapp" class="form-control mb-2">
    </div>
    <div class="col-md-4">
        <label>City</label>
        <input name="city" class="form-control mb-2">
    </div>
    <div class="col-md-4">
        <label>State</label>
        <input name="state" class="form-control mb-2">
    </div>
    <div class="col-md-12">
        <label>Address</label>
        <textarea name="address" class="form-control mb-3"></textarea>
    </div>
</div>

{{-- REQUIREMENT --}}
<h5 class="mb-2">Requirement</h5>
<div class="row">
    <div class="col-md-4">
        <label>Enquiry For</label>
        <select name="enquiry_for" class="form-control mb-2">
            <option>Package</option>
            <option>Hotel</option>
            <option>Flight</option>
            <option>Visa</option>
            <option>Train</option>
            <option>Group Departure</option>
        </select>
    </div>
    <div class="col-md-4">
        <label>Status</label>
        <select name="status" class="form-control mb-2">
            <option>New</option>
            <option>In Progress</option>
            <option>Converted</option>
            <option>Lost</option>
        </select>
    </div>
    <div class="col-md-4">
    <label>Travel Destination / Location</label>
    <input name="destination" class="form-control mb-2"
           placeholder="Eg: Dubai, Bali, Paris">
</div>
    <div class="col-md-4">
        <label>Travel Date</label>
        <input type="date" name="travel_date" class="form-control mb-2">
    </div>
    <div class="col-md-4">
        <label>No of Days</label>
        <input type="number" name="no_of_days" class="form-control mb-2">
    </div>
    <div class="col-md-4">
        <label>Budget</label>
        <input type="number" name="budget" class="form-control mb-2">
    </div>
    <div class="col-md-12">
        <label>Comment</label>
        <textarea name="comment" class="form-control mb-3"></textarea>
    </div>
</div>

{{-- PAX INFO --}}
<h5 class="mb-2">Pax Info</h5>
<div class="row">
    <div class="col-md-4">
        <label>No of Persons</label>
        <input type="number" name="no_of_person" class="form-control mb-2">
    </div>
    <div class="col-md-4">
        <label>No of Children</label>
        <input type="number" name="no_of_child" class="form-control mb-3">
    </div>
</div>

{{-- TEAM INFO --}}
<h5 class="mb-2">Team Info</h5>
<div class="row">
    <div class="col-md-4">
        <label>Enquiry Date</label>
        <input type="date" name="enquiry_date" class="form-control mb-2">
    </div>
    <div class="col-md-4">
        <label>Follow Up Date</label>
        <input type="date" name="follow_up_date" class="form-control mb-2">
    </div>
    <div class="col-md-4">
        <label>Reference</label>
        <select name="reference" class="form-control mb-2">
            <option>Advertise</option>
            <option>Customer Reference</option>
            <option>Social Media</option>
            <option>Telephone</option>
            <option>Website</option>
        </select>
    </div>

    @if(auth()->user()->role === 'admin')
    <div class="col-md-4">
        <label>Allocate To</label>
        <select name="assigned_to" class="form-control mb-2">
            <option value="">-- Select Agent --</option>
            @foreach($agents as $agent)
                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="col-md-12">
        <label>Enquiry Suggestion Comment</label>
        <textarea name="enquiry_suggestion_comment" class="form-control mb-3"></textarea>
    </div>
</div>

<button class="btn btn-success">Save Lead</button>
</form>

@endsection
@extends('layouts.app')
@section('content')

<h4>Enquiry Requirement</h4>

<table class="table table-bordered table-sm">
<tr><th>Destination</th><td>{{ $lead->destination }}</td></tr>
<tr><th>Travel Date</th><td>{{ $lead->travel_date }}</td></tr>
<tr><th>No of Days</th><td>{{ $lead->no_of_days }}</td></tr>
<tr><th>Pax</th><td>{{ $lead->no_of_person }}</td></tr>
<tr><th>Budget</th><td>{{ $lead->budget }}</td></tr>
<tr><th>Comment</th><td>{{ $lead->comment }}</td></tr>
</table>

<hr>

<h5>Discussion</h5>

@foreach($lead->dmcComments as $msg)
<div class="border p-2 mb-1">
    <strong>{{ $msg->user->name }}</strong>
    <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
    <p class="mb-0">{{ $msg->message }}</p>
</div>
@endforeach

<form method="POST" action="{{ route('dmc.comment.store',$lead) }}">
@csrf
<textarea name="message" class="form-control mb-2" placeholder="Write message..."></textarea>
<button class="btn btn-primary btn-sm">Send</button>
</form>

@endsection
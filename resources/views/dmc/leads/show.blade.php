@extends('layouts.app')
@section('content')

{{-- HEADER --}}
<div class="mb-3">
    <h4 class="mb-0">
        {{ $lead->name }}
    </h4>
    <small class="text-muted">
        Enquiry shared with you
    </small>
</div>

<div class="row">

    {{-- ================= LEFT : CONVERSATION ================= --}}
    <div class="col-md-8">

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                Discussion
            </div>

            {{-- CHAT BODY --}}
            <div class="card-body"
                 style="height: 420px; overflow-y: auto; background:#f8f9fa">

                @forelse($lead->dmcComments->sortBy('created_at') as $msg)

                    {{-- MESSAGE BUBBLE --}}
                    <div class="mb-3
                        {{ $msg->user->role === 'dmc' ? 'text-end' : '' }}">

                        <div class="d-inline-block p-2 rounded
                            {{ $msg->user->role === 'dmc'
                                ? 'bg-primary text-white'
                                : 'bg-white border' }}"
                             style="max-width:75%">

                            <div class="fw-semibold small">
                                {{ $msg->user->name }}
                            </div>

                            <div>
                                {{ $msg->message }}
                            </div>

                            <div class="small mt-1
                                {{ $msg->user->role === 'dmc'
                                    ? 'text-light'
                                    : 'text-muted' }}">
                                {{ $msg->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                    </div>

                @empty
                    <p class="text-muted text-center mt-4">
                        No discussion yet
                    </p>
                @endforelse

            </div>

            {{-- MESSAGE BOX --}}
            <div class="card-footer bg-light">
                <form method="POST"
                      action="{{ route('dmc.comment.store',$lead) }}">
                    @csrf

                    <div class="input-group">
                        <textarea name="message"
                                  class="form-control"
                                  rows="2"
                                  placeholder="Type your message..."
                                  required></textarea>
                        <button class="btn btn-primary">
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    {{-- ================= RIGHT : ENQUIRY DETAILS ================= --}}
    <div class="col-md-4">

        <div class="card shadow-sm sticky-top" style="top:20px">
            <div class="card-header bg-secondary text-white">
                Enquiry Requirement
            </div>

            <div class="card-body p-0">
                <table class="table table-sm table-bordered mb-0">
                    <tr>
                        <th width="40%">Destination</th>
                        <td>{{ $lead->destination ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Travel Date</th>
                        <td>{{ $lead->travel_date ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>No of Days</th>
                        <td>{{ $lead->no_of_days ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Pax</th>
                        <td>
                            {{ $lead->no_of_person ?? '—' }}
                            @if($lead->no_of_child)
                                + {{ $lead->no_of_child }} Child
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Budget</th>
                        <td>
                            ₹ {{ number_format($lead->budget ?? 0, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Comment</th>
                        <td>{{ $lead->comment ?? '—' }}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

</div>

@endsection
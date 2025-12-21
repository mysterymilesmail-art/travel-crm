@extends('layouts.app')

@section('content')
<h4>DMC Enquiries</h4>

<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Destination</th>
            <th>Travel Date</th>
            <th>Pax</th>
            <th>Days</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    @forelse($leads as $index => $lead)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $lead->destination }}</td>
            <td>{{ $lead->travel_date ?? '—' }}</td>
            <td>{{ $lead->no_of_person ?? '—' }}</td>
            <td>{{ $lead->no_of_days ?? '—' }}</td>
            <td>
                <a href="{{ route('dmc.leads.show', $lead) }}"
                   class="btn btn-sm btn-primary">
                    View
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted">
                No enquiries shared with you
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
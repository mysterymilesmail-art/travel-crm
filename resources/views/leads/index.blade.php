@extends('layouts.app')

@section('content')

<a href="{{ route('leads.create') }}" class="btn btn-primary mb-3">
    Add Lead
</a>

<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Destination</th>
            <th>Enquiry For</th>
            <th>Status</th>
            <th>Follow Up</th>
            <th>Assigned To</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    @forelse($leads as $index => $lead)
        <tr>
            {{-- SERIAL NUMBER (PAGINATION SAFE) --}}
            <td>
                {{ ($leads->currentPage() - 1) * $leads->perPage() + $index + 1 }}
            </td>

            <td>{{ $lead->name }}</td>

            <td>{{ $lead->destination ?? '—' }}</td>

            <td>{{ $lead->enquiry_for ?? '—' }}</td>

            <td>
                <span class="badge bg-info">
                    {{ $lead->status }}
                </span>
            </td>

            <td>
                {{ $lead->follow_up_date
                    ? \Carbon\Carbon::parse($lead->follow_up_date)->format('d M Y')
                    : '—' }}
            </td>

            <td>
                {{ $lead->assignedAgent->name ?? 'Unassigned' }}
            </td>

            <td>
                <a href="{{ route('leads.show', $lead) }}"
                   class="btn btn-sm btn-primary">
                    View
                </a>

                <a href="{{ route('leads.edit', $lead) }}"
                   class="btn btn-sm btn-warning">
                    Edit
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center text-muted">
                No leads found
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

{{-- PAGINATION --}}
<div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        Showing
        {{ $leads->firstItem() ?? 0 }}
        to
        {{ $leads->lastItem() ?? 0 }}
        of
        {{ $leads->total() }}
        leads
    </div>

    <div>
        {{ $leads->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
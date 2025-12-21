@extends('layouts.app')

@section('content')
<h4>DMC Shared Leads</h4>

<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Lead</th>
            <th>DMC</th>
            <th>Destination</th>
            <th>Assigned Agent</th>
            <th>Last DMC Comment</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    @forelse($dmcLeads as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->lead->name }}</td>
            <td>{{ $row->dmc->name }}</td>
            <td>{{ $row->lead->destination }}</td>
            <td>{{ $row->lead->assignedAgent->name ?? '-' }}</td>
            <td>
                {{ optional($row->lead->dmcComments->last())->message ?? '—' }}
            </td>
            <td>
                <a href="{{ route('leads.show', $row->lead) }}"
                   class="btn btn-sm btn-primary">
                    Open Lead
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted">
                No leads shared with DMC
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
<table class="table table-sm table-striped mb-0">
    <tr>
        <th>Lead</th>
        <th>Summary</th>
        <th>Follow-Up Date</th>
        @if(auth()->user()->role === 'admin')
<th>Agent</th>
@endif
        <th>Action</th>
    </tr>

@forelse($items as $log)
<tr>
    <td>{{ $log->lead->name }}</td>
    <td>{{ Str::limit($log->call_summary, 40) }}</td>
    <td>
        <span class="badge bg-secondary">
            {{ \Carbon\Carbon::parse($log->next_follow_up_date)->format('d M Y') }}
        </span>
    </td>
    @if(auth()->user()->role === 'admin')
<td>
    {{ $log->lead->assignedAgent->name ?? 'Unassigned' }}
</td>
@endif
    <td>
        <a href="{{ route('leads.show', $log->lead_id) }}" class="btn btn-sm btn-outline-primary">
            View Lead
        </a>
    </td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center text-muted py-3">
        No follow-ups found
    </td>
</tr>
@endforelse
</table>
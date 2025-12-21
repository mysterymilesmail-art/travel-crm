<hr>

<h5>Lead Edit History</h5>

<table class="table table-bordered table-sm">
    <tr>
        <th>Field</th>
        <th>Old Value</th>
        <th>New Value</th>
        <th>Edited By</th>
        <th>Updated At</th>
    </tr>

@forelse($lead->editLogs as $log)
<tr>
    <td>{{ ucfirst(str_replace('_',' ', $log->field_name)) }}</td>
    <td>{{ $log->previous_value ?? '—' }}</td>
    <td>{{ $log->new_value ?? '—' }}</td>
    <td>
        <span class="badge bg-dark">
            {{ $log->user->name ?? 'System' }}
        </span>
    </td>
    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-muted">
        No changes recorded yet
    </td>
</tr>
@endforelse
</table>
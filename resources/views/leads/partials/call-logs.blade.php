<hr>

<h5>Call Activity Log</h5>

{{-- ADD CALL LOG FORM --}}
<form method="POST" action="{{ route('calllogs.store', $lead) }}" class="mb-3">
@csrf

<div class="row">
    <div class="col-md-8">
        <label>Call Summary</label>
        <textarea name="call_summary" class="form-control" required></textarea>
    </div>

    <div class="col-md-4">
        <label>Next Follow Up Date</label>
        <input type="date" name="next_follow_up_date" class="form-control">
    </div>
</div>

<button class="btn btn-sm btn-primary mt-2">Save Call Log</button>
</form>

{{-- CALL LOG LIST --}}
<table class="table table-bordered table-sm">
    <tr>
        <th>Added By</th>
        <th>Summary</th>
        <th>Next Follow Up</th>
        <th>Date</th>
    </tr>

@forelse($lead->callLogs as $log)
<tr>
    <td>{{ $log->user->name ?? '—' }}</td>
    <td>{{ $log->call_summary }}</td>
    <td>
        {{ $log->next_follow_up_date
            ? \Carbon\Carbon::parse($log->next_follow_up_date)->format('d M Y')
            : '—' }}
    </td>
    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center text-muted">
        No call logs added yet
    </td>
</tr>
@endforelse
</table>
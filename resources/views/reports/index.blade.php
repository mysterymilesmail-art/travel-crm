@extends('layouts.app')
@section('content')

<h4 class="mb-3">Reports</h4>

{{-- FILTERS --}}
<form class="row mb-4">
    <div class="col-md-3">
        <label>From</label>
        <input type="date" name="from" class="form-control" value="{{ $from }}">
    </div>

    <div class="col-md-3">
        <label>To</label>
        <input type="date" name="to" class="form-control" value="{{ $to }}">
    </div>

    <div class="col-md-3">
        <label>Agent</label>
        <select name="agent_id" class="form-control">
            <option value="">All Agents</option>
            @foreach($agents as $agent)
                <option value="{{ $agent->id }}"
                    {{ $agentId==$agent->id?'selected':'' }}>
                    {{ $agent->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 align-self-end">
        <button class="btn btn-primary">Apply</button>
    </div>
</form>

{{-- AGENT PERFORMANCE --}}
<h5>Agent Performance</h5>
<table class="table table-bordered table-sm mb-4">
    <tr>
        <th>Agent</th>
        <th>Total Leads</th>
        <th>Converted</th>
        <th>In Progress</th>
        <th>Lost</th>
    </tr>

@forelse($agentReport as $row)
<tr>
    <td>{{ $row->assignedAgent->name ?? 'Unassigned' }}</td>
    <td>{{ $row->total }}</td>
    <td class="text-success">{{ $row->converted }}</td>
    <td class="text-warning">{{ $row->in_progress }}</td>
    <td class="text-danger">{{ $row->lost }}</td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">No data found</td>
</tr>
@endforelse
</table>

{{-- DESTINATION REPORT --}}
<h5>Destination Analytics</h5>
<table class="table table-bordered table-sm">
    <tr>
        <th>Destination</th>
        <th>Total Enquiries</th>
        <th>Converted</th>
        <th>Lost</th>
        <th>Conversion %</th>
    </tr>

@forelse($destinationReport as $row)
<tr>
    <td>{{ $row->destination }}</td>
    <td>{{ $row->total }}</td>
    <td class="text-success">{{ $row->converted }}</td>
    <td class="text-danger">{{ $row->lost }}</td>
    <td>
        {{ $row->total > 0 ? round(($row->converted / $row->total) * 100, 2) : 0 }}%
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">No data found</td>
</tr>
@endforelse
</table>

@endsection
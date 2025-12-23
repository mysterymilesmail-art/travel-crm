@extends('layouts.app')

@section('content')

{{-- ================= PAGE HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Leads</h4>
    <a href="{{ route('leads.create') }}" class="btn btn-primary">
        + Add Lead
    </a>
</div>

{{-- ================= FILTERS ================= --}}
<div class="card mb-4 shadow-sm">
    <div class="card-header fw-bold">
        Filters
    </div>

    <div class="card-body">
        <form method="GET">

            {{-- ROW 1 --}}
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="q"
                           value="{{ request('q') }}"
                           class="form-control"
                           placeholder="Name, phone, destination, comment">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        @foreach(['New','In Progress','Converted','Lost'] as $status)
                            <option value="{{ $status }}"
                                {{ request('status') === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if(auth()->user()->role === 'admin')
                <div class="col-md-2">
                    <label class="form-label">Assigned Agent</label>
                    <select name="assigned_to" class="form-control">
                        <option value="">All Agents</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}"
                                {{ request('assigned_to') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="col-md-2">
                    <label class="form-label">Travel Date</label>
                    <input type="date" name="travel_date"
                           value="{{ request('travel_date') }}"
                           class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Follow Up Date</label>
                    <input type="date" name="follow_up_date"
                           value="{{ request('follow_up_date') }}"
                           class="form-control">
                </div>
            </div>

            {{-- ROW 2 --}}
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Enquiry Date</label>
                    <input type="date" name="enquiry_date"
                           value="{{ request('enquiry_date') }}"
                           class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Destination</label>
                    <input type="text" name="destination"
                           value="{{ request('destination') }}"
                           class="form-control">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-dark w-100">
                        Apply Filters
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('leads.index') }}"
                       class="btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>

{{-- ================= LISTING ================= --}}
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm mb-0">
            <thead class="table-light sticky-top">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Destination</th>

                    {{-- SORTABLE TRAVEL DATE --}}
                    <th>
                        <a class="text-decoration-none"
                           href="{{ request()->fullUrlWithQuery([
                                'sort' => 'travel_date',
                                'order' => ($sortField === 'travel_date' && $sortOrder === 'asc') ? 'desc' : 'asc'
                           ]) }}">
                            Travel Date
                            @if($sortField === 'travel_date')
                                {{ $sortOrder === 'asc' ? '↑' : '↓' }}
                            @endif
                        </a>
                    </th>

                    <th>Pax</th>
                    <th>WhatsApp</th>
                    <th>Comment</th>

                    {{-- SORTABLE FOLLOW UP DATE --}}
                    <th>
                        <a class="text-decoration-none"
                           href="{{ request()->fullUrlWithQuery([
                                'sort' => 'follow_up_date',
                                'order' => ($sortField === 'follow_up_date' && $sortOrder === 'asc') ? 'desc' : 'asc'
                           ]) }}">
                            Follow Up
                            @if($sortField === 'follow_up_date')
                                {{ $sortOrder === 'asc' ? '↑' : '↓' }}
                            @endif
                        </a>
                    </th>

                    <th>Assigned To</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($leads as $index => $lead)
                <tr>
                    <td>
                        {{ ($leads->currentPage() - 1) * $leads->perPage() + $index + 1 }}
                    </td>

                    <td class="fw-semibold">{{ $lead->name }}</td>
                    <td>{{ $lead->destination ?? '—' }}</td>

                    <td>
                        {{ $lead->travel_date
                            ? \Carbon\Carbon::parse($lead->travel_date)->format('d M Y')
                            : '—' }}
                    </td>

                    <td>
                        {{ $lead->no_of_person ?? 0 }}
                        @if($lead->no_of_child)
                            <span class="text-muted">+ {{ $lead->no_of_child }} C</span>
                        @endif
                    </td>

                    <td>{{ $lead->whatsapp ?? '—' }}</td>

                    <td title="{{ $lead->comment }}">
                        {{ \Illuminate\Support\Str::limit($lead->comment, 35) ?? '—' }}
                    </td>

                    <td>
                        {{ $lead->follow_up_date
                            ? \Carbon\Carbon::parse($lead->follow_up_date)->format('d M Y')
                            : '—' }}
                    </td>

                    <td>
                        <span class="badge bg-light text-dark">
                            {{ $lead->assignedAgent->name ?? 'Unassigned' }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('leads.show',$lead) }}"
                           class="btn btn-sm btn-primary">
                            View
                        </a>
                        <a href="{{ route('leads.edit',$lead) }}"
                           class="btn btn-sm btn-warning">
                            Edit
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-4">
                        No leads found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ================= PAGINATION ================= --}}
<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted">
        Showing {{ $leads->firstItem() ?? 0 }}
        to {{ $leads->lastItem() ?? 0 }}
        of {{ $leads->total() }} leads
    </div>

    <div>
        {{ $leads->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
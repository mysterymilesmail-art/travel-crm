@extends('layouts.app')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0">DMC Enquiries</h4>
        <small class="text-muted">
            Enquiries shared with you by MysteryMiles
        </small>
    </div>
</div>

{{-- ================= SEARCH ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-header fw-bold">
        Search Enquiries
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       class="form-control"
                       placeholder="Name, destination, pax, days, comment">
            </div>

            <div class="col-md-2">
                <button class="btn btn-dark w-100">
                    Search
                </button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('dmc.leads') }}"
                   class="btn btn-outline-secondary w-100">
                    Reset
                </a>
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
                    <th>Client Name</th>
                    <th>Destination</th>
                    <th>Travel Date</th>
                    <th>Pax</th>
                    <th>Days</th>
                    <th>Comment</th>
                    <th width="120">Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($leads as $index => $lead)
                <tr>
                    <td>
                        {{ ($leads->currentPage() - 1) * $leads->perPage() + $index + 1 }}
                    </td>

                    <td class="fw-semibold">
                        {{ $lead->name }}
                    </td>

                    <td>
                        {{ $lead->destination ?? '—' }}
                    </td>

                    <td>
                        {{ $lead->travel_date
                            ? \Carbon\Carbon::parse($lead->travel_date)->format('d M Y')
                            : '—' }}
                    </td>

                    <td>
                        {{ $lead->no_of_person ?? '—' }}
                        @if($lead->no_of_child)
                            <span class="text-muted">
                                + {{ $lead->no_of_child }} C
                            </span>
                        @endif
                    </td>

                    <td>
                        {{ $lead->no_of_days ?? '—' }}
                    </td>

                    <td title="{{ $lead->comment }}">
                        {{ \Illuminate\Support\Str::limit($lead->comment, 40) ?? '—' }}
                    </td>

                    <td>
                        <a href="{{ route('dmc.leads.show', $lead) }}"
                           class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8"
                        class="text-center text-muted py-4">
                        No enquiries shared with you
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
        of {{ $leads->total() }} enquiries
    </div>

    <div>
        {{ $leads->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
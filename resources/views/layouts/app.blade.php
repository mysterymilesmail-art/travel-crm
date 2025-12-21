<!doctype html>
<html>
<head>
    <title>MysteryMiles CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        @if(auth()->user()->role != 'dmc')
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                MysteryMiles CRM
            </a>
        @elseif(auth()->user()->role === 'dmc')
            <a class="navbar-brand" href="{{ route('dmc.leads') }}">
                MysteryMiles
            </a>
        @endif

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#crmNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="crmNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- ================= ADMIN ================= --}}
                @if(auth()->user()->role === 'admin')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('leads.*') ? 'active' : '' }}"
                           href="{{ route('leads.index') }}">
                            Leads
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}"
                           href="{{ url('/users') }}">
                            Users
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                           href="{{ route('reports.index') }}">
                            Reports
                        </a>
                    </li>

                    {{-- 🔥 NEW: ADMIN DMC LEADS --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dmc.leads') ? 'active' : '' }}"
                           href="{{ route('admin.dmc.leads') }}">
                            DMC Leads
                        </a>
                    </li>

                @endif

                {{-- ================= AGENT ================= --}}
                @if(auth()->user()->role === 'agent')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('leads.*') ? 'active' : '' }}"
                           href="{{ route('leads.index') }}">
                            My Leads
                        </a>
                    </li>

                @endif

                {{-- ================= DMC ================= --}}
                @if(auth()->user()->role === 'dmc')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dmc.leads*') ? 'active' : '' }}"
                           href="{{ route('dmc.leads') }}">
                            My Leads
                        </a>
                    </li>

                @endif

            </ul>

            {{-- RIGHT SIDE --}}
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-3">
                    <span class="navbar-text text-white">
                        {{ auth()->user()->name }} ({{ strtoupper(auth()->user()->role) }})
                    </span>
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-danger">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- PAGE CONTENT --}}
<div class="container mt-4">
    @yield('content')
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
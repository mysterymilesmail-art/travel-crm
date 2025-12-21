@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Users</h4>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Add User</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-sm">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

@foreach($users as $user)
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
        <span class="badge bg-{{ $user->role === 'admin' ? 'dark' : 'secondary' }}">
            {{ ucfirst($user->role) }}
        </span>
    </td>
    <td>
        <span class="badge bg-{{ $user->status ? 'success' : 'danger' }}">
            {{ $user->status ? 'Active' : 'Inactive' }}
        </span>
    </td>
    <td>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
    </td>
</tr>
@endforeach
</table>

{{ $users->links() }}

@endsection
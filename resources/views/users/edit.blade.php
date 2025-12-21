@extends('layouts.app')

@section('content')
<h4>Edit User</h4>

<form method="POST" action="{{ route('users.update', $user) }}">
@csrf
@method('PUT')

<label class="form-label">Full Name</label>
<input class="form-control mb-2" name="name" value="{{ $user->name }}" required>

<label class="form-label">Email Address</label>
<input class="form-control mb-2" value="{{ $user->email }}" disabled>

<label class="form-label">Phone Number</label>
<input class="form-control mb-2" name="phone" value="{{ $user->phone }}">

<label class="form-label">User Role</label>
<select name="role" class="form-control mb-2">
    <option value="agent" {{ $user->role=='agent'?'selected':'' }}>Agent</option>
    <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
    <option value="dmc" {{ $user->role=='dmc'?'selected':'' }}>DMC</option>
</select>

<label class="form-label">Account Status</label>
<select name="status" class="form-control mb-2">
    <option value="1" {{ $user->status?'selected':'' }}>Active</option>
    <option value="0" {{ !$user->status?'selected':'' }}>Inactive</option>
</select>

<hr>

<label class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
<input type="password" class="form-control mb-2" name="password">

<label class="form-label">Confirm New Password</label>
<input type="password" class="form-control mb-3" name="password_confirmation">

<button class="btn btn-primary">Update User</button>
</form>
@endsection
@extends('layouts.app')

@section('content')
<h4>Add User</h4>

<form method="POST" action="{{ route('users.store') }}">
@csrf

<label class="form-label">Full Name</label>
<input class="form-control mb-2" name="name" required>

<label class="form-label">Email Address</label>
<input class="form-control mb-2" name="email" required>

<label class="form-label">Phone Number</label>
<input class="form-control mb-2" name="phone">

<label class="form-label">User Role</label>
<select name="role" class="form-control mb-2">
    <option value="agent">Agent</option>
    <option value="admin">Admin</option>
    <option value="dmc">DMC</option>
</select>

<label class="form-label">Account Status</label>
<select name="status" class="form-control mb-2">
    <option value="1">Active</option>
    <option value="0">Inactive</option>
</select>

<label class="form-label">Password</label>
<input type="password" class="form-control mb-2" name="password" required>

<label class="form-label">Confirm Password</label>
<input type="password" class="form-control mb-3" name="password_confirmation" required>

<button class="btn btn-success">Create User</button>
</form>
@endsection
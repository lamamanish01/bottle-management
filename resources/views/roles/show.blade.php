@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user-tag me-2"></i>{{ $role->name }}</h1>
    <div>
        @can('edit roles')
            <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
        @endcan
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Role Name:</strong> {{ $role->name }}</p>
                <p><strong>Created:</strong> {{ $role->created_at->format('d M, Y h:i A') }}</p>
                <p><strong>Last Updated:</strong> {{ $role->updated_at->format('d M, Y h:i A') }}</p>
                <p><strong>Users with this Role:</strong> {{ $role->users->count() }}</p>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-lock me-2"></i>Permissions</h6>
                        @php
                            $permissions = $role->permissions ?? collect();
                        @endphp
                        @forelse($permissions as $permission)
                            <span class="badge bg-info me-1 mb-1">{{ $permission->name }}</span>
                        @empty
                            <span class="text-muted">No permissions assigned to this role.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($role->name === 'Super Admin')
    <div class="alert alert-warning mt-3">
        <i class="fas fa-exclamation-triangle me-2"></i>
        This is the <strong>Super Admin</strong> role. Users with this role have access to everything.
    </div>
@endif

@if($role->users->count() > 0)
    <h4 class="mt-4"><i class="fas fa-users me-2"></i>Users with this Role</h4>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($role->users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d M, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection

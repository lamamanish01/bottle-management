@extends('layouts.app')

@section('title', 'Permission Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-lock me-2"></i>{{ $permission->name }}</h1>
    <div>
        @can('edit permissions')
            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
        @endcan
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Permission Name:</strong> {{ $permission->name }}</p>
                <p><strong>Created:</strong> {{ $permission->created_at->format('d M, Y h:i A') }}</p>
                <p><strong>Last Updated:</strong> {{ $permission->updated_at->format('d M, Y h:i A') }}</p>
                <p><strong>Guard:</strong> {{ $permission->guard_name ?? 'web' }}</p>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-user-tag me-2"></i>Roles with this Permission</h6>
                        @php
                            $roles = $permission->roles ?? collect();
                        @endphp
                        @forelse($roles as $role)
                            <span class="badge bg-primary me-1 mb-1">{{ $role->name }}</span>
                        @empty
                            <span class="text-muted">No roles assigned to this permission.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

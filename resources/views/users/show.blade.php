@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user me-2"></i>{{ $user->name }}</h1>
    <div>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong>
                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'manager' ? 'warning' : 'info') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </p>
                <p><strong>Registered:</strong> {{ $user->created_at->format('d M Y h:i A') }}</p>
                <p><strong>Last Updated:</strong> {{ $user->updated_at->format('d M Y h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

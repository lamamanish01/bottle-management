@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user me-2"></i>{{ $user->name }}</h3>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <strong>Name</strong>
                <p class="mb-3">{{ $user->name }}</p>
            </div>
            <div class="col-md-6">
                <strong>Email</strong>
                <p class="mb-3">{{ $user->email }}</p>
            </div>

            {{-- ✅ FIX: Display all roles correctly --}}
            <div class="col-md-6">
                <strong>Role(s)</strong>
                <p class="mb-3">
                    @php $roles = $user->getRoleNames(); @endphp
                    @if($roles->count())
                        @foreach($roles as $roleName)
                            @php
                                // Optional: set badge color based on role name
                                $badgeClass = match($roleName) {
                                    'admin'        => 'bg-primary',
                                    'manager'      => 'bg-success',
                                    'super-admin'  => 'bg-danger',
                                    default        => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} me-1">{{ ucfirst($roleName) }}</span>
                        @endforeach
                    @else
                        <span class="text-muted fst-italic">No role assigned</span>
                    @endif
                </p>
            </div>

            <div class="col-md-6">
                <strong>Joined</strong>
                <p class="mb-3">{{ $user->created_at->format('F j, Y, g:i A') }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back to Users</a>

            {{-- Optionally hide Edit button for super‑admins or based on permission --}}
            @can('edit users')
                @if(!$user->hasRole('super-admin'))
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning"><i class="fas fa-edit me-1"></i>Edit</a>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection

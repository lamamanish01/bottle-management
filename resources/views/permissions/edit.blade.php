@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-lock-edit me-2"></i>Edit Permission</h1>
    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Permission Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $permission->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="text-muted">Use the format: <strong>action resource</strong> (e.g., "view users", "edit posts")</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user-tag me-2"></i>Create Role</h1>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Role Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g., Editor, Moderator" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <hr>
            <div class="mb-3">
                <label class="form-label fw-bold">Permissions</label>
                <div class="mb-2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="selectAll">
                        <label class="form-check-label" for="selectAll">Select All</label>
                    </div>
                </div>
                <div class="row">
                    @foreach ($permissions as $permission)
                        <div class="col-md-3 col-sm-4 col-6 mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->name }}" id="perm-{{ $permission->id }}">
                                <label class="form-check-label" for="perm-{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = this.checked);
    });
</script>
@endpush
@endsection

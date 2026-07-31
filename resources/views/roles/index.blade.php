@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-user-tag me-2 text-primary"></i>Roles</h5>
        @can('create roles')
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle me-1"></i> Create Role
            </a>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th>Created</th>
                        <th class="text-center" width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        @php
                            $permissions = $role->permissions ?? collect();
                            $visible = $permissions->take(3);
                            $remaining = max($permissions->count() - 3, 0);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $role->name }}</strong></td>
                            <td>
                                @forelse($visible as $permission)
                                    <span class="badge bg-info me-1 mb-1">{{ $permission->name }}</span>
                                @empty
                                    <span class="text-muted">No Permissions</span>
                                @endforelse
                                @if($remaining > 0)
                                    <span class="badge bg-secondary me-1 mb-1">+{{ $remaining }} more</span>
                                @endif
                            </td>
                            <td>{{ optional($role->created_at)->format('d M, Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('view roles')
                                        <a href="{{ route('roles.show', $role->id) }}" class="btn btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('edit roles')
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('delete roles')
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">No roles found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $roles->links() }}
    </div>
</div>
@endsection

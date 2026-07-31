@extends('layouts.app')

@section('title', 'Permissions')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-lock me-2 text-primary"></i>Permissions</h5>
        @can('create permissions')
            <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle me-1"></i> Create Permission
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
                        <th>Created</th>
                        <th class="text-center" width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $permission->name }}</strong></td>
                            <td>{{ optional($permission->created_at)->format('d M, Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('view permissions')
                                        <a href="{{ route('permissions.show', $permission->id) }}" class="btn btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('edit permissions')
                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('delete permissions')
                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline-block;">
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
                        <tr><td colspan="4" class="text-center text-muted py-3">No permissions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination with Results Counter -->
        <div class="row align-items-center mt-3">
            <div class="col-md-6">
                <small class="text-muted">
                    Showing {{ $permissions->firstItem() ?? 0 }} to {{ $permissions->lastItem() ?? 0 }} of {{ $permissions->total() }} results
                </small>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

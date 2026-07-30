@extends('layouts.app')

@section('title', 'Bottle Types')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-boxes me-2 text-primary"></i>Bottle Types</h5>
        <a href="{{ route('bottle-types.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle me-1"></i> Add Type
        </a>
    </div>
    <div class="card-body">
        <!-- Optional search -->
        <form method="GET" action="{{ route('bottle-types.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                @if(request('search'))
                    <a href="{{ route('bottle-types.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bottleTypes as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td><strong>{{ $type->name }}</strong></td>
                            <td>{{ $type->unit }}</td>
                            <td>{{ $type->description ?? '—' }}</td>
                            <td class="text-center">
                                <a href="{{ route('bottle-types.edit', $type) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('bottle-types.destroy', $type) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this bottle type?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">No bottle types defined.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $bottleTypes->links() }}
    </div>
</div>
@endsection

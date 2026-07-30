@extends('layouts.app')

@section('title', 'Collectors')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users me-2 text-primary"></i>Collectors</h5>
        <a href="{{ route('collectors.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle me-1"></i> Add Collector
        </a>
    </div>
    <div class="card-body">
        <!-- Search Form -->
        <form method="GET" action="{{ route('collectors.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by name, phone..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                @if(request('search'))
                    <a href="{{ route('collectors.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Collections</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($collectors as $collector)
                        <tr>
                            <td>{{ $collector->id }}</td>
                            <td><strong>{{ $collector->name }}</strong></td>
                            <td>{{ $collector->phone ?? '—' }}</td>
                            <td>{{ $collector->address ?? '—' }}</td>
                            <td><span class="badge bg-info">{{ $collector->collections->count() }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('collectors.show', $collector) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('collectors.edit', $collector) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('collectors.destroy', $collector) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this collector?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No collectors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $collectors->links() }}
    </div>
</div>
@endsection

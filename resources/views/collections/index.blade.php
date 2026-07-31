@extends('layouts.app')

@section('title', 'Collections')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-recycle me-2 text-primary"></i>Collections</h5>
        @can('create collections')
            <a href="{{ route('collections.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus-circle me-1"></i> New Collection
            </a>
        @endcan
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('collections.index') }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search collector or notes..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="from" class="form-control" placeholder="From" value="{{ request('from') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="to" class="form-control" placeholder="To" value="{{ request('to') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" type="submit"><i class="fas fa-search"></i> Filter</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Collector</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Paid</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($collections as $collection)
                        <tr>
                            <td>{{ $collection->id }}</td>
                            <td>{{ $collection->collection_date }}</td>
                            <td>{{ $collection->collector->name }}</td>
                            <td>{{ $collection->bottleType->name }}</td>
                            <td>{{ number_format($collection->quantity, 2) }} {{ $collection->bottleType->unit }}</td>
                            <td>NPR {{ number_format($collection->total_price, 2) }}</td>
                            <td>{{ $collection->paid ? 'Yes' : 'No' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('view collections')
                                        <a href="{{ route('collections.show', $collection) }}" class="btn btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('edit collections')
                                        <a href="{{ route('collections.edit', $collection) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('delete collections')
                                        <form action="{{ route('collections.destroy', $collection) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Delete this collection?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-3">No collections recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $collections->links() }}
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Buyers')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-store me-2 text-primary"></i>Buyers</h5>
        <a href="{{ route('buyers.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle me-1"></i> Add Buyer
        </a>
    </div>
    <div class="card-body">
        <!-- Search Form -->
        <form method="GET" action="{{ route('buyers.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by name, contact, email..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                @if(request('search'))
                    <a href="{{ route('buyers.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Contact Person</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($buyers as $buyer)
                        <tr>
                            <td>{{ $buyer->id }}</td>
                            <td><strong>{{ $buyer->name }}</strong></td>
                            <td>{{ $buyer->contact_person ?? '—' }}</td>
                            <td>{{ $buyer->phone ?? '—' }}</td>
                            <td>{{ $buyer->email ?? '—' }}</td>
                            <td class="text-center">
                                <a href="{{ route('buyers.show', $buyer) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('buyers.edit', $buyer) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('buyers.destroy', $buyer) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this buyer?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No buyers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $buyers->links() }}
    </div>
</div>
@endsection

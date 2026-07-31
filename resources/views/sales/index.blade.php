@extends('layouts.app')

@section('title', 'Sales')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-truck me-2 text-primary"></i>Sales</h5>
        @can('create sales')
            <a href="{{ route('sales.create') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-plus-circle me-1"></i> New Sale
            </a>
        @endcan
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('sales.index') }}" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search buyer or notes..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="from" class="form-control" placeholder="From" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="to" class="form-control" placeholder="To" value="{{ request('to') }}">
            </div>
            <div class="col-md-2">
                <select name="payment_status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary w-100" type="submit"><i class="fas fa-search"></i> Filter</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Buyer</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->sale_date }}</td>
                            <td>{{ $sale->buyer->name }}</td>
                            <td>{{ $sale->bottleType->name }}</td>
                            <td>{{ number_format($sale->quantity, 2) }} {{ $sale->bottleType->unit }}</td>
                            <td>NPR {{ number_format($sale->total_price, 2) }}</td>
                            <td>
                                @php
                                    $statusClass = ['pending' => 'danger', 'partial' => 'warning', 'paid' => 'success'][$sale->payment_status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($sale->payment_status) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('view sales')
                                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('edit sales')
                                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('delete sales')
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Delete this sale?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-3">No sales recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $sales->links() }}
    </div>
</div>
@endsection

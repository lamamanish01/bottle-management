@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-truck me-2"></i>{{ $supplier->name }}</h1>
    <div>
        @can('edit suppliers')
            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
        @endcan
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Company/Name:</strong> {{ $supplier->name }}</p>
                <p><strong>Contact Person:</strong> {{ $supplier->contact_person ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $supplier->phone ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $supplier->email ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $supplier->address ?? 'N/A' }}</p>
                <p><strong>Tax ID / PAN:</strong> {{ $supplier->tax_id ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Payment Terms:</strong> {{ $supplier->payment_terms ?? 'N/A' }}</p>
                <p><strong>Bank Name:</strong> {{ $supplier->bank_name ?? 'N/A' }}</p>
                <p><strong>Bank Account:</strong> {{ $supplier->bank_account ?? 'N/A' }}</p>
                <p><strong>Status:</strong>
                    <span class="badge {{ $supplier->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $supplier->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
                <p><strong>Registered:</strong> {{ $supplier->created_at->format('d M, Y h:i A') }}</p>
                <p><strong>Last Updated:</strong> {{ $supplier->updated_at->format('d M, Y h:i A') }}</p>
            </div>
        </div>
        @if($supplier->notes)
            <div class="mt-3">
                <strong>Notes:</strong>
                <p class="text-muted">{{ $supplier->notes }}</p>
            </div>
        @endif
    </div>
</div>

@if($supplier->collections->count())
    <h4 class="mt-4"><i class="fas fa-recycle me-2"></i>Collection History</h4>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supplier->collections as $collection)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $collection->collection_date }}</td>
                                <td>{{ $collection->bottleType->name }}</td>
                                <td>{{ number_format($collection->quantity, 2) }} {{ $collection->bottleType->unit }}</td>
                                <td>NPR {{ number_format($collection->total_price, 2) }}</td>
                                <td>{{ $collection->paid ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection

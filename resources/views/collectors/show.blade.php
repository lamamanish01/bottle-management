@extends('layouts.app')

@section('title', 'Collector Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user me-2"></i>{{ $collector->name }}</h1>
    <div>
        <a href="{{ route('collectors.edit', $collector) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('collectors.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> {{ $collector->name }}</p>
                <p><strong>Phone:</strong> {{ $collector->phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $collector->address ?? 'N/A' }}</p>
                <p><strong>Registered:</strong> {{ $collector->created_at->format('d M Y') }}</p>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Statistics</h6>
                        <p><strong>Total Collections:</strong> {{ $collector->collections->count() }}</p>
                        <p><strong>Total Quantity Collected:</strong> {{ number_format($collector->collections->sum('quantity'), 2) }} kg</p>
                        <p><strong>Total Amount Paid:</strong> NPR {{ number_format($collector->collections->sum('total_price'), 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($collector->collections->count())
    <h4 class="mt-4"><i class="fas fa-recycle me-2"></i>Collection History</h4>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Date</th><th>Type</th><th>Quantity</th><th>Total Price</th><th>Paid</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($collector->collections as $collection)
                            <tr>
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

@extends('layouts.app')

@section('title', 'Buyer Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-store me-2"></i>{{ $buyer->name }}</h1>
    <div>
        <a href="{{ route('buyers.edit', $buyer) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('buyers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> {{ $buyer->name }}</p>
                <p><strong>Contact Person:</strong> {{ $buyer->contact_person ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $buyer->phone ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $buyer->email ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $buyer->address ?? 'N/A' }}</p>
                <p><strong>Registered:</strong> {{ $buyer->created_at->format('d M Y') }}</p>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Statistics</h6>
                        <p><strong>Total Sales:</strong> {{ $buyer->sales->count() }}</p>
                        <p><strong>Total Quantity Purchased:</strong> {{ number_format($buyer->sales->sum('quantity'), 2) }} kg</p>
                        <p><strong>Total Revenue:</strong> NPR {{ number_format($buyer->sales->sum('total_price'), 2) }}</p>
                        <p><strong>Pending Payments:</strong>
                            @php
                                $pending = $buyer->sales->whereIn('payment_status', ['pending', 'partial'])->sum('total_price');
                            @endphp
                            NPR {{ number_format($pending, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($buyer->sales->count())
    <h4 class="mt-4"><i class="fas fa-truck me-2"></i>Purchase History</h4>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Date</th><th>Type</th><th>Quantity</th><th>Total Price</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($buyer->sales as $sale)
                            <tr>
                                <td>{{ $sale->sale_date }}</td>
                                <td>{{ $sale->bottleType->name }}</td>
                                <td>{{ number_format($sale->quantity, 2) }} {{ $sale->bottleType->unit }}</td>
                                <td>NPR {{ number_format($sale->total_price, 2) }}</td>
                                <td><span class="badge bg-{{ $sale->payment_status == 'paid' ? 'success' : ($sale->payment_status == 'partial' ? 'warning' : 'danger') }}">{{ ucfirst($sale->payment_status) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection

@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-credit-card me-2"></i>Payment #{{ $payment->id }}</h1>
    <div>
        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Date:</strong> {{ $payment->payment_date }}</p>
                <p><strong>Type:</strong>
                    <span class="badge {{ $payment->type == 'incoming' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($payment->type) }}
                    </span>
                </p>
                <p><strong>Related To:</strong>
                    @if ($payment->payable_type == 'App\Models\Collection')
                        Collection #{{ $payment->payable_id }}
                    @elseif ($payment->payable_type == 'App\Models\Sale')
                        Sale #{{ $payment->payable_id }}
                    @else
                        {{ $payment->payable_type }}
                    @endif
                </p>
            </div>
            <div class="col-md-6">
                <p><strong>Amount:</strong> NPR {{ number_format($payment->amount, 2) }}</p>
                <p><strong>Reference:</strong> {{ $payment->reference ?? 'N/A' }}</p>
                <p><strong>Notes:</strong> {{ $payment->notes ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

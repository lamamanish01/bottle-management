@extends('layouts.app')

@section('title', 'Collection Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-recycle me-2"></i>Collection #{{ $collection->id }}</h1>
    <div>
        <a href="{{ route('collections.edit', $collection) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('collections.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Date:</strong> {{ $collection->collection_date }}</p>
                <p><strong>Collector:</strong> <a href="{{ route('collectors.show', $collection->collector) }}">{{ $collection->collector->name }}</a></p>
                <p><strong>Bottle Type:</strong> {{ $collection->bottleType->name }}</p>
                <p><strong>Quantity:</strong> {{ number_format($collection->quantity, 2) }} {{ $collection->bottleType->unit }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Unit Price:</strong> NPR {{ number_format($collection->unit_price ?? 0, 2) }}</p>
                <p><strong>Total Price:</strong> NPR {{ number_format($collection->total_price, 2) }}</p>
                <p><strong>Paid:</strong>
                    @if($collection->paid)
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-danger">Unpaid</span>
                    @endif
                </p>
                <p><strong>Notes:</strong> {{ $collection->notes ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="mt-3">
            @if(!$collection->paid)
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">
                    <i class="fas fa-hand-holding-usd me-1"></i> Record Payment
                </button>
            @endif
        </div>
    </div>
</div>

@if($collection->payments->count())
    <h4 class="mt-4"><i class="fas fa-credit-card me-2"></i>Payments Made</h4>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Date</th><th>Amount</th><th>Reference</th><th>Notes</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($collection->payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date }}</td>
                                <td>NPR {{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->reference ?? '—' }}</td>
                                <td>{{ $payment->notes ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel"><i class="fas fa-hand-holding-usd me-2"></i>Record Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm" action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payable_id" value="{{ $collection->id }}">
                    <input type="hidden" name="payable_type" value="App\Models\Collection">
                    <input type="hidden" name="type" value="outgoing">

                    <div class="mb-3">
                        <label for="amount" class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">NPR</span>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="payment_date" class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="reference" class="form-label fw-bold">Reference</label>
                        <input type="text" class="form-control" id="reference" name="reference" placeholder="Cheque #, Transfer ID, etc.">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-bold">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="paymentForm" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Record Payment
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

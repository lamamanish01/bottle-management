@extends('layouts.app')

@section('title', 'Create Sale')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-truck me-2"></i>Create Sale</h1>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Sales
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('sales.store') }}">
            @csrf

            <div class="row">
                <!-- Buyer -->
                <div class="col-md-6 mb-3">
                    <label for="buyer_id" class="form-label fw-bold">Buyer <span class="text-danger">*</span></label>
                    <select class="form-select @error('buyer_id') is-invalid @enderror" id="buyer_id" name="buyer_id" required>
                        <option value="">Select Buyer</option>
                        @foreach ($buyers as $buyer)
                            <option value="{{ $buyer->id }}" {{ old('buyer_id') == $buyer->id ? 'selected' : '' }}>
                                {{ $buyer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('buyer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bottle Type -->
                <div class="col-md-6 mb-3">
                    <label for="bottle_type_id" class="form-label fw-bold">Bottle Type <span class="text-danger">*</span></label>
                    <select class="form-select @error('bottle_type_id') is-invalid @enderror" id="bottle_type_id" name="bottle_type_id" required>
                        <option value="">Select Type</option>
                        @foreach ($bottleTypes as $type)
                            <option value="{{ $type->id }}" {{ old('bottle_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} ({{ $type->unit }})
                            </option>
                        @endforeach
                    </select>
                    @error('bottle_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sale Date -->
                <div class="col-md-6 mb-3">
                    <label for="sale_date" class="form-label fw-bold">Sale Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('sale_date') is-invalid @enderror" id="sale_date" name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required>
                    @error('sale_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Quantity -->
                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label fw-bold">Quantity <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" placeholder="e.g., 100.50" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Unit Price -->
                <div class="col-md-6 mb-3">
                    <label for="unit_price" class="form-label fw-bold">Unit Price (selling) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">NPR</span>
                        <input type="number" step="0.01" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price" name="unit_price" value="{{ old('unit_price') }}" placeholder="0.00" required>
                        @error('unit_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Total Price (auto-calculated via JS) -->
                <div class="col-md-6 mb-3">
                    <label for="total_price_display" class="form-label fw-bold">Total Price</label>
                    <div class="input-group">
                        <span class="input-group-text">NPR</span>
                        <input type="text" class="form-control" id="total_price_display" value="0.00" readonly>
                    </div>
                    <small class="text-muted">Automatically calculated as Quantity × Unit Price</small>
                    <!-- Hidden field to submit total_price -->
                    <input type="hidden" name="total_price" id="total_price" value="0">
                </div>

                <!-- Payment Status -->
                <div class="col-md-6 mb-3">
                    <label for="payment_status" class="form-label fw-bold">Payment Status</label>
                    <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status">
                        <option value="pending" {{ old('payment_status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Due Date -->
                <div class="col-md-6 mb-3">
                    <label for="due_date" class="form-label fw-bold">Due Date</label>
                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}">
                    @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Receive Full Payment Now (checkbox) -->
                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="receive_payment" name="receive_payment" value="1" {{ old('receive_payment') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="receive_payment">
                            <i class="fas fa-check-circle text-success me-1"></i> Receive full payment now
                        </label>
                        <small class="d-block text-muted">If checked, a payment record will be created for the total amount.</small>
                    </div>
                </div>

                <!-- Payment Reference (conditional) -->
                <div class="col-md-6 mb-3" id="reference_group" style="{{ old('receive_payment') ? '' : 'display:none;' }}">
                    <label for="reference" class="form-label fw-bold">Payment Reference (optional)</label>
                    <input type="text" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference') }}" placeholder="Cheque #, Transfer ID, etc.">
                    @error('reference')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="col-12 mb-3">
                    <label for="notes" class="form-label fw-bold">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Any additional notes about this sale...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Save Sale
                </button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-calculate total price
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const unitPriceInput = document.getElementById('unit_price');
        const totalDisplay = document.getElementById('total_price_display');
        const totalHidden = document.getElementById('total_price');

        function calculateTotal() {
            const qty = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(unitPriceInput.value) || 0;
            const total = qty * price;
            totalDisplay.value = total.toFixed(2);
            totalHidden.value = total.toFixed(2);
        }

        quantityInput.addEventListener('input', calculateTotal);
        unitPriceInput.addEventListener('input', calculateTotal);

        // Toggle reference field visibility based on checkbox
        const receivePaymentCheck = document.getElementById('receive_payment');
        const referenceGroup = document.getElementById('reference_group');

        receivePaymentCheck.addEventListener('change', function() {
            if (this.checked) {
                referenceGroup.style.display = '';
            } else {
                referenceGroup.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection

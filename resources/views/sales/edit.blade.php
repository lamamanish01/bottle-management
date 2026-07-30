@extends('layouts.app')

@section('title', 'Edit Sale')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-truck-edit me-2"></i>Edit Sale #{{ $sale->id }}</h1>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('sales.update', $sale) }}">
            @csrf @method('PUT')
            <div class="row">
                <!-- Buyer -->
                <div class="col-md-6 mb-3">
                    <label for="buyer_id" class="form-label fw-bold">Buyer <span class="text-danger">*</span></label>
                    <select class="form-select @error('buyer_id') is-invalid @enderror" id="buyer_id" name="buyer_id" required>
                        <option value="">Select Buyer</option>
                        @foreach ($buyers as $buyer)
                            <option value="{{ $buyer->id }}" {{ old('buyer_id', $sale->buyer_id) == $buyer->id ? 'selected' : '' }}>
                                {{ $buyer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('buyer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Bottle Type -->
                <div class="col-md-6 mb-3">
                    <label for="bottle_type_id" class="form-label fw-bold">Bottle Type <span class="text-danger">*</span></label>
                    <select class="form-select @error('bottle_type_id') is-invalid @enderror" id="bottle_type_id" name="bottle_type_id" required>
                        <option value="">Select Type</option>
                        @foreach ($bottleTypes as $type)
                            <option value="{{ $type->id }}" {{ old('bottle_type_id', $sale->bottle_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} ({{ $type->unit }})
                            </option>
                        @endforeach
                    </select>
                    @error('bottle_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Sale Date -->
                <div class="col-md-6 mb-3">
                    <label for="sale_date" class="form-label fw-bold">Sale Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('sale_date') is-invalid @enderror" id="sale_date" name="sale_date" value="{{ old('sale_date', $sale->sale_date) }}" required>
                    @error('sale_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Quantity -->
                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label fw-bold">Quantity <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $sale->quantity) }}" required>
                    @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Unit Price -->
                <div class="col-md-6 mb-3">
                    <label for="unit_price" class="form-label fw-bold">Selling Unit Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">NPR</span>
                        <input type="number" step="0.01" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price" name="unit_price" value="{{ old('unit_price', $sale->unit_price) }}" required>
                        @error('unit_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Total Price -->
                <div class="col-md-6 mb-3">
                    <label for="total_price_display" class="form-label fw-bold">Total Price</label>
                    <div class="input-group">
                        <span class="input-group-text">NPR</span>
                        <input type="text" class="form-control" id="total_price_display" value="{{ old('total_price', $sale->total_price) }}" readonly>
                    </div>
                    <small class="text-muted">Quantity × Unit Price</small>
                    <input type="hidden" name="total_price" id="total_price" value="{{ old('total_price', $sale->total_price) }}">
                </div>

                <!-- Payment Status -->
                <div class="col-md-6 mb-3">
                    <label for="payment_status" class="form-label fw-bold">Payment Status</label>
                    <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status">
                        <option value="pending" {{ old('payment_status', $sale->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="partial" {{ old('payment_status', $sale->payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="paid" {{ old('payment_status', $sale->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                    @error('payment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Due Date -->
                <div class="col-md-6 mb-3">
                    <label for="due_date" class="form-label fw-bold">Due Date</label>
                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', $sale->due_date) }}">
                    @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Notes -->
                <div class="col-12 mb-3">
                    <label for="notes" class="form-label fw-bold">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2">{{ old('notes', $sale->notes) }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qty = document.getElementById('quantity');
        const price = document.getElementById('unit_price');
        const totalDisplay = document.getElementById('total_price_display');
        const totalHidden = document.getElementById('total_price');
        function calc() {
            const t = (parseFloat(qty.value) || 0) * (parseFloat(price.value) || 0);
            totalDisplay.value = t.toFixed(2);
            totalHidden.value = t.toFixed(2);
        }
        qty.addEventListener('input', calc);
        price.addEventListener('input', calc);
    });
</script>
@endpush
@endsection

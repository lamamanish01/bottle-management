@extends('layouts.app')

@section('title', 'Add Payment')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-credit-card me-2"></i>Add Payment</h1>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="row">
                <!-- Payment Type -->
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label fw-bold">Payment Type <span class="text-danger">*</span></label>
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="incoming" {{ old('type') == 'incoming' ? 'selected' : '' }}>Incoming (from Buyer)</option>
                        <option value="outgoing" {{ old('type') == 'outgoing' ? 'selected' : '' }}>Outgoing (to Collector)</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Related ID (Sale or Collection) -->
                <div class="col-md-6 mb-3">
                    <label for="payable_id" class="form-label fw-bold">Related Record ID <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('payable_id') is-invalid @enderror" id="payable_id" name="payable_id" value="{{ old('payable_id') }}" placeholder="e.g., 1" required>
                    @error('payable_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">ID of the Sale (for incoming) or Collection (for outgoing).</small>
                </div>

                <!-- Payment Date -->
                <div class="col-md-6 mb-3">
                    <label for="payment_date" class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                    @error('payment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Amount -->
                <div class="col-md-6 mb-3">
                    <label for="amount" class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">NPR</span>
                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" required>
                        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Reference -->
                <div class="col-md-6 mb-3">
                    <label for="reference" class="form-label fw-bold">Reference</label>
                    <input type="text" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference') }}" placeholder="Cheque #, Transfer ID, etc.">
                    @error('reference') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Notes -->
                <div class="col-12 mb-3">
                    <label for="notes" class="form-label fw-bold">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save</button>
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

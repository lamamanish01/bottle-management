@extends('layouts.app')

@section('title', 'Add Collection')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-recycle me-2"></i>Add Collection</h1>
    <a href="{{ route('collections.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('collections.store') }}">
            @csrf
            <div class="row">
                <!-- Collector -->
                <div class="col-md-6 mb-3">
                    <label for="collector_id" class="form-label fw-bold">Collector <span class="text-danger">*</span></label>
                    <select class="form-select @error('collector_id') is-invalid @enderror" id="collector_id" name="collector_id" required>
                        <option value="">Select Collector</option>
                        @foreach ($collectors as $collector)
                            <option value="{{ $collector->id }}" {{ old('collector_id') == $collector->id ? 'selected' : '' }}>
                                {{ $collector->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('collector_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                    @error('bottle_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Collection Date -->
                <div class="col-md-6 mb-3">
                    <label for="collection_date" class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('collection_date') is-invalid @enderror" id="collection_date" name="collection_date" value="{{ old('collection_date', date('Y-m-d')) }}" required>
                    @error('collection_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Quantity -->
                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label fw-bold">Quantity <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" placeholder="e.g., 100.50" required>
                    @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Unit Price (you pay) -->
                <div class="col-md-6 mb-3">
                    <label for="unit_price" class="form-label fw-bold">Unit Price (you pay)</label>
                    <div class="input-group">
                        <span class="input-group-text">NPR</span>
                        <input type="number" step="0.01" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price" name="unit_price" value="{{ old('unit_price') }}" placeholder="0.00">
                        @error('unit_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Total Price (auto) -->
                <div class="col-md-6 mb-3">
                    <label for="total_price_display" class="form-label fw-bold">Total Price</label>
                    <div class="input-group">
                        <span class="input-group-text">NPR</span>
                        <input type="text" class="form-control" id="total_price_display" value="0.00" readonly>
                    </div>
                    <small class="text-muted">Quantity × Unit Price</small>
                    <input type="hidden" name="total_price" id="total_price" value="0">
                </div>

                <!-- Pay Now -->
                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="pay_now" name="pay_now" value="1" {{ old('pay_now') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="pay_now">
                            <i class="fas fa-hand-holding-usd text-success me-1"></i> Pay collector now
                        </label>
                        <small class="d-block text-muted">If checked, a payment record (outgoing) will be created.</small>
                    </div>
                </div>

                <!-- Payment Reference (conditional) -->
                <div class="col-md-6 mb-3" id="reference_group" style="{{ old('pay_now') ? '' : 'display:none;' }}">
                    <label for="reference" class="form-label fw-bold">Payment Reference</label>
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
                <a href="{{ route('collections.index') }}" class="btn btn-secondary">Cancel</a>
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

        const payCheck = document.getElementById('pay_now');
        const refGroup = document.getElementById('reference_group');
        payCheck.addEventListener('change', function() {
            refGroup.style.display = this.checked ? '' : 'none';
        });
    });
</script>
@endpush
@endsection

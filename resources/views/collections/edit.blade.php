@extends('layouts.app')

@section('title', 'Edit Collection')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-recycle me-2"></i>Edit Collection #{{ $collection->id }}</h1>
    <a href="{{ route('collections.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('collections.update', $collection) }}">
            @csrf @method('PUT')
            <div class="row">
                <!-- Collector Dropdown -->
                <div class="col-md-6 mb-3">
                    <label for="collector_id" class="form-label fw-bold">Collector</label>
                    <select class="form-select @error('collector_id') is-invalid @enderror" id="collector_id" name="collector_id">
                        <option value="">Select Collector</option>
                        @foreach ($collectors as $collector)
                            <option value="{{ $collector->id }}" {{ old('collector_id', $collection->collector_id) == $collector->id ? 'selected' : '' }}>
                                {{ $collector->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('collector_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Optional if you select a Supplier below</small>
                </div>

                <!-- Supplier Dropdown -->
                <div class="col-md-6 mb-3">
                    <label for="supplier_id" class="form-label fw-bold">Supplier</label>
                    <select class="form-select @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id">
                        <option value="">Select Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $collection->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Optional if you select a Collector above</small>
                </div>

                <!-- Bottle Type -->
                <div class="col-md-6 mb-3">
                    <label for="bottle_type_id" class="form-label fw-bold">Bottle Type <span class="text-danger">*</span></label>
                    <select class="form-select @error('bottle_type_id') is-invalid @enderror" id="bottle_type_id" name="bottle_type_id" required>
                        <option value="">Select Type</option>
                        @foreach ($bottleTypes as $type)
                            <option value="{{ $type->id }}" {{ old('bottle_type_id', $collection->bottle_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} ({{ $type->unit }})
                            </option>
                        @endforeach
                    </select>
                    @error('bottle_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Date -->
                <div class="col-md-6 mb-3">
                    <label for="collection_date" class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('collection_date') is-invalid @enderror" id="collection_date" name="collection_date" value="{{ old('collection_date', $collection->collection_date) }}" required>
                    @error('collection_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Quantity -->
                <div class="col-md-6 mb-3">
                    <label for="quantity" class="form-label fw-bold">Quantity <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $collection->quantity) }}" required>
                    @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Unit Price -->
                <div class="col-md-6 mb-3">
                    <label for="unit_price" class="form-label fw-bold">Unit Price (you pay)</label>
                    <div class="input-group">
                        <span class="input-group-text">NPR</span>
                        <input type="number" step="0.01" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price" name="unit_price" value="{{ old('unit_price', $collection->unit_price) }}">
                        @error('unit_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Total Price -->
                <div class="col-md-6 mb-3">
                    <label for="total_price_display" class="form-label fw-bold">Total Price</label>
                    <div class="input-group">
                        <span class="input-group-text">NPR</span>
                        <input type="text" class="form-control" id="total_price_display" value="{{ old('total_price', $collection->total_price) }}" readonly>
                    </div>
                    <input type="hidden" name="total_price" id="total_price" value="{{ old('total_price', $collection->total_price) }}">
                </div>

                <!-- Paid -->
                <div class="col-md-6 mb-3">
                    <div class="form-check mt-4">
                        <!-- Hidden input to send value when unchecked -->
                        <input type="hidden" name="paid" value="0">
                        <input class="form-check-input" type="checkbox" id="paid" name="paid" value="1"
                            {{ old('paid', $collection->paid) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="paid">
                            <i class="fas fa-check-circle text-success me-1"></i> Paid
                        </label>
                    </div>
                </div>

                <!-- Notes -->
                <div class="col-12 mb-3">
                    <label for="notes" class="form-label fw-bold">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2">{{ old('notes', $collection->notes) }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
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
    });
</script>
@endpush
@endsection

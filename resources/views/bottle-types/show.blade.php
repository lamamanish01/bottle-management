@extends('layouts.app')

@section('title', 'Bottle Type Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-box me-2"></i>{{ $bottleType->name }}</h1>
    <div>
        <a href="{{ route('bottle-types.edit', $bottleType) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('bottle-types.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <p><strong>Name:</strong> {{ $bottleType->name }}</p>
        <p><strong>Unit:</strong> {{ $bottleType->unit }}</p>
        <p><strong>Description:</strong> {{ $bottleType->description ?? 'N/A' }}</p>
        <p><strong>Created:</strong> {{ $bottleType->created_at->format('d M Y') }}</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-recycle me-2 text-success"></i>Collections</h5>
            </div>
            <div class="card-body">
                <p><strong>Total Collected:</strong> {{ number_format($bottleType->collections->sum('quantity'), 2) }} {{ $bottleType->unit }}</p>
                <p><strong>Number of Collections:</strong> {{ $bottleType->collections->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-truck me-2 text-danger"></i>Sales</h5>
            </div>
            <div class="card-body">
                <p><strong>Total Sold:</strong> {{ number_format($bottleType->sales->sum('quantity'), 2) }} {{ $bottleType->unit }}</p>
                <p><strong>Number of Sales:</strong> {{ $bottleType->sales->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

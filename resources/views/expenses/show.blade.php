@extends('layouts.app')

@section('title', 'Expense Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-coins me-2"></i>Expense #{{ $expense->id }}</h1>
    <div>
        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Category:</strong> {{ $expense->category }}</p>
                <p><strong>Date:</strong> {{ $expense->expense_date }}</p>
                <p><strong>Amount:</strong> NPR {{ number_format($expense->amount, 2) }}</p>
                <p><strong>Description:</strong> {{ $expense->description ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

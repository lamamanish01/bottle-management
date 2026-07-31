@extends('layouts.app')

@section('title', 'Expenses')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-coins me-2 text-primary"></i>Expenses</h5>
        @can('create expenses')
            <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle me-1"></i> Add Expense
            </a>
        @endcan
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('expenses.index') }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search category or description..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="from" class="form-control" placeholder="From" value="{{ request('from') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="to" class="form-control" placeholder="To" value="{{ request('to') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100" type="submit"><i class="fas fa-search"></i> Filter</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($expenses as $expense)
                        <tr>
                            <td>{{ $expense->id }}</td>
                            <td>{{ $expense->expense_date }}</td>
                            <td><strong>{{ $expense->category }}</strong></td>
                            <td>NPR {{ number_format($expense->amount, 2) }}</td>
                            <td>{{ $expense->description ?? '—' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('view expenses')
                                        <a href="{{ route('expenses.show', $expense) }}" class="btn btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('edit expenses')
                                        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('delete expenses')
                                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Delete this expense?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">No expenses recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $expenses->links() }}
    </div>
</div>
@endsection

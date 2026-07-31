@extends('layouts.app')

@section('title', 'Payments')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-credit-card me-2 text-primary"></i>All Payments</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Related To</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->payment_date }}</td>
                            <td>
                                <span class="badge {{ $payment->type == 'incoming' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($payment->type) }}
                                </span>
                            </td>
                            <td>
                                @if ($payment->payable_type == 'App\Models\Collection')
                                    Collection #{{ $payment->payable_id }}
                                @else
                                    Sale #{{ $payment->payable_id }}
                                @endif
                            </td>
                            <td>NPR {{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->reference ?? '—' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('view payments')
                                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('edit payments')
                                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('delete payments')
                                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-3">No payments recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $payments->links() }}
    </div>
</div>
@endsection

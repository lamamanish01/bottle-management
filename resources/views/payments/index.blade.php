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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No payments recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $payments->links() }}
    </div>
</div>
@endsection

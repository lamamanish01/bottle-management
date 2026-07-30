@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .stat-card-simple {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border-left: 4px solid #667eea;
        transition: 0.2s;
        display: block;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
    }
    .stat-card-simple:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        transform: translateY(-3px);
        text-decoration: none;
        color: inherit;
    }
    .stat-card-simple .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
    }
    .stat-card-simple .stat-label {
        color: #718096;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-card-simple .stat-icon {
        font-size: 2rem;
        opacity: 0.5;
        color: #667eea;
    }
    .border-left-green { border-left-color: #38a169; }
    .border-left-orange { border-left-color: #ed8936; }
    .border-left-red { border-left-color: #e53e3e; }
    .border-left-purple { border-left-color: #805ad5; }
    .border-left-blue { border-left-color: #3182ce; }

    .quick-action-btn {
        border-radius: 50px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .quick-action-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .recent-item {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .recent-item:last-child {
        border-bottom: 0;
    }
    .badge-collection { background: #38a169; }
    .badge-sale { background: #e53e3e; }
    .badge-payment-incoming { background: #2b6cb0; }
    .badge-payment-outgoing { background: #e53e3e; }

    .stock-badge {
        font-size: 0.85rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .stock-ok { background: #c6f6d5; color: #22543d; }
    .stock-low { background: #fefcbf; color: #975a16; }
    .stock-empty { background: #fed7d7; color: #9b2c2c; }
</style>

<!-- Quick Action Buttons -->
<div class="d-flex gap-3 mb-4 flex-wrap">
    <a href="{{ route('collections.create') }}" class="btn btn-success quick-action-btn">
        <i class="fas fa-plus-circle me-2"></i> New Collection
    </a>
    <a href="{{ route('sales.create') }}" class="btn btn-danger quick-action-btn">
        <i class="fas fa-plus-circle me-2"></i> New Sale
    </a>
    <a href="{{ route('collectors.create') }}" class="btn btn-outline-secondary quick-action-btn">
        <i class="fas fa-user-plus me-2"></i> Add Collector
    </a>
    <a href="{{ route('buyers.create') }}" class="btn btn-outline-secondary quick-action-btn">
        <i class="fas fa-store-plus me-2"></i> Add Buyer
    </a>
</div>

<!-- Stats Row (Clickable Cards) -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <a href="{{ route('collectors.index') }}" class="stat-card-simple border-left-green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number">{{ $totalCollectors }}</div>
                    <div class="stat-label">Collectors</div>
                </div>
                <div class="stat-icon"><i class="fas fa-users"></i></div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('buyers.index') }}" class="stat-card-simple border-left-orange">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number">{{ $totalBuyers }}</div>
                    <div class="stat-label">Buyers</div>
                </div>
                <div class="stat-icon"><i class="fas fa-store"></i></div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('collections.index') }}" class="stat-card-simple border-left-purple">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number">{{ number_format($totalCollections, 1) }}</div>
                    <div class="stat-label">Collected (kg)</div>
                </div>
                <div class="stat-icon"><i class="fas fa-recycle"></i></div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('sales.index') }}" class="stat-card-simple border-left-red">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number">{{ number_format($totalSales, 1) }}</div>
                    <div class="stat-label">Sold (kg)</div>
                </div>
                <div class="stat-icon"><i class="fas fa-truck"></i></div>
            </div>
        </a>
    </div>
</div>

<!-- Payment Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <a href="{{ route('payments.index') }}" class="stat-card-simple border-left-blue">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number">NPR {{ number_format($totalIncoming, 2) }}</div>
                    <div class="stat-label">Incoming Payments</div>
                </div>
                <div class="stat-icon"><i class="fas fa-arrow-down"></i></div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('payments.index') }}" class="stat-card-simple border-left-red">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number">NPR {{ number_format($totalOutgoing, 2) }}</div>
                    <div class="stat-label">Outgoing Payments</div>
                </div>
                <div class="stat-icon"><i class="fas fa-arrow-up"></i></div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('payments.index') }}" class="stat-card-simple border-left-green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number">NPR {{ number_format($netBalance, 2) }}</div>
                    <div class="stat-label">Net Balance</div>
                </div>
                <div class="stat-icon"><i class="fas fa-balance-scale"></i></div>
            </div>
        </a>
    </div>
</div>

<!-- Revenue & Profit Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card-simple border-left-purple">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number">NPR {{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-label">Revenue</div>
                </div>
                <div class="stat-icon"><i class="fas fa-money-bill"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card-simple border-left-red">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number">NPR {{ number_format($totalCost, 2) }}</div>
                    <div class="stat-label">Total Cost</div>
                </div>
                <div class="stat-icon"><i class="fas fa-coins"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card-simple border-left-green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number">NPR {{ number_format($profit, 2) }}</div>
                    <div class="stat-label">Profit</div>
                </div>
                <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content: Stock + Recent Activities -->
<div class="row g-4">
    <!-- Stock Table -->
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-boxes me-2 text-primary"></i>Current Stock</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Type</th><th>Stock</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($stockData as $type)
                                @php
                                    $stock = ($type->total_in ?? 0) - ($type->total_out ?? 0);
                                    $statusClass = $stock <= 0 ? 'stock-empty' : ($stock < 50 ? 'stock-low' : 'stock-ok');
                                    $statusLabel = $stock <= 0 ? 'Empty' : ($stock < 50 ? 'Low' : 'OK');
                                @endphp
                                <tr>
                                    <td><strong>{{ $type->name }}</strong></td>
                                    <td>{{ number_format($stock, 2) }} {{ $type->unit }}</td>
                                    <td><span class="stock-badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-muted">No bottle types defined.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities (Collections & Sales) -->
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clock me-2 text-primary"></i>Recent Activity</h5>
                <small class="text-muted">Latest entries</small>
            </div>
            <div class="card-body p-0">
                @php
                    $activities = collect();
                    foreach ($recentCollections as $c) {
                        $activities->push([
                            'type' => 'collection',
                            'date' => $c->collection_date,
                            'description' => $c->collector->name . ' collected ' . number_format($c->quantity, 2) . ' ' . $c->bottleType->unit . ' of ' . $c->bottleType->name,
                            'badge' => 'Collection',
                            'badgeClass' => 'badge-collection',
                        ]);
                    }
                    foreach ($recentSales as $s) {
                        $activities->push([
                            'type' => 'sale',
                            'date' => $s->sale_date,
                            'description' => $s->buyer->name . ' bought ' . number_format($s->quantity, 2) . ' ' . $s->bottleType->unit . ' of ' . $s->bottleType->name,
                            'badge' => 'Sale',
                            'badgeClass' => 'badge-sale',
                        ]);
                    }
                    // Add recent payments
                    foreach ($recentPayments as $p) {
                        $activities->push([
                            'type' => 'payment',
                            'date' => $p->payment_date,
                            'description' => ($p->type == 'incoming' ? 'Incoming payment' : 'Outgoing payment') . ' of NPR ' . number_format($p->amount, 2) . ' for ' . class_basename($p->payable_type) . ' #' . $p->payable_id,
                            'badge' => ucfirst($p->type),
                            'badgeClass' => $p->type == 'incoming' ? 'badge-payment-incoming' : 'badge-payment-outgoing',
                        ]);
                    }
                    $activities = $activities->sortByDesc('date')->take(10);
                @endphp
                @forelse ($activities as $activity)
                    <div class="recent-item d-flex justify-content-between align-items-center px-3">
                        <div>
                            <span class="badge {{ $activity['badgeClass'] }} me-2">{{ $activity['badge'] }}</span>
                            <span>{{ $activity['description'] }}</span>
                        </div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($activity['date'])->diffForHumans() }}</small>
                    </div>
                @empty
                    <div class="p-3 text-muted">No recent activity.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Chart (if data exists) -->
@if(isset($dates) && count($dates) > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Trend (Last 7 Days)</h5>
            </div>
            <div class="card-body">
                <canvas id="trendChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('trendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($dates) !!},
                datasets: [
                    {
                        label: 'Collections (kg)',
                        data: {!! json_encode($collectionsData) !!},
                        borderColor: '#38a169',
                        backgroundColor: 'rgba(56, 161, 105, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 3,
                    },
                    {
                        label: 'Sales (kg)',
                        data: {!! json_encode($salesData) !!},
                        borderColor: '#e53e3e',
                        backgroundColor: 'rgba(229, 62, 62, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 3,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endpush
@endif

@endsection

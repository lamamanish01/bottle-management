<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Sale;
use App\Models\BottleType;
use App\Models\Payment;
use App\Models\Collector;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $totalCollectors = Collector::count();
        $totalBuyers = Buyer::count();
        $totalCollections = Collection::sum('quantity');
        $totalSales = Sale::sum('quantity');

        // Revenue and expenses
        $totalRevenue = Sale::sum('total_price');
        $totalExpenses = Payment::where('type', 'outgoing')->sum('amount');
        $totalCost = $totalExpenses; // if you have additional expenses, add them
        $profit = $totalRevenue - $totalCost;

        // Payment summary
        $totalIncoming = Payment::where('type', 'incoming')->sum('amount');
        $totalOutgoing = Payment::where('type', 'outgoing')->sum('amount');
        $netBalance = $totalIncoming - $totalOutgoing;

        // Stock per type
        $stockData = BottleType::withCount([
            'collections as total_in' => function ($query) {
                $query->select(DB::raw('SUM(quantity)'));
            },
            'sales as total_out' => function ($query) {
                $query->select(DB::raw('SUM(quantity)'));
            }
        ])->get();

        // Recent activities (collections & sales)
        $recentCollections = Collection::with(['collector', 'bottleType'])->latest()->limit(5)->get();
        $recentSales = Sale::with(['buyer', 'bottleType'])->latest()->limit(5)->get();

        // Recent payments (latest 5)
        $recentPayments = Payment::with(['payable'])->latest()->limit(5)->get();

        // Chart data: last 7 days collection & sale quantities
        $dates = collect();
        $collectionsData = [];
        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dates->push(now()->subDays($i)->format('M d'));
            $collectionsData[] = Collection::whereDate('collection_date', $date)->sum('quantity');
            $salesData[] = Sale::whereDate('sale_date', $date)->sum('quantity');
        }

        return view('dashboard.index', compact(
            'totalCollectors', 'totalBuyers', 'totalCollections', 'totalSales',
            'totalRevenue', 'totalCost', 'profit',
            'totalIncoming', 'totalOutgoing', 'netBalance',
            'stockData', 'recentCollections', 'recentSales', 'recentPayments',
            'dates', 'collectionsData', 'salesData'
        ));
    }
}

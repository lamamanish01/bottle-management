<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Buyer;
use App\Models\BottleType;
use App\Models\Payment;
use App\Http\Requests\StoreSaleRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SaleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view sales', only: ['index', 'show']),
            new Middleware('permission:create sales', only: ['create', 'store']),
            new Middleware('permission:edit sales', only: ['edit', 'update']),
            new Middleware('permission:delete sales', only: ['destroy']),
        ];
    }

    public function index()
    {
        $sales = Sale::with(['buyer', 'bottleType'])->latest()->paginate(15);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $buyers = Buyer::all();
        $bottleTypes = BottleType::all();
        return view('sales.create', compact('buyers', 'bottleTypes'));
    }

    public function store(StoreSaleRequest $request)
    {
        $validated = $request->validated();
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $sale = Sale::create($validated);

        // If payment received at sale time, record incoming payment
        if ($request->has('receive_payment') && $request->receive_payment) {
            Payment::create([
                'payable_id' => $sale->id,
                'payable_type' => Sale::class,
                'payment_date' => now(),
                'amount' => $sale->total_price,
                'type' => 'incoming',
                'reference' => $request->input('reference'),
                'notes' => 'Payment for sale #' . $sale->id,
            ]);
            $sale->update(['payment_status' => 'paid']);
        }

        return redirect()->route('sales.index')->with('success', 'Sale recorded.');
    }

    public function show(Sale $sale)
    {
        $sale->load(['buyer', 'bottleType', 'payments']);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $buyers = Buyer::all();
        $bottleTypes = BottleType::all();
        return view('sales.edit', compact('sale', 'buyers', 'bottleTypes'));
    }

    public function update(StoreSaleRequest $request, Sale $sale)
    {
        $validated = $request->validated();
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $sale->update($validated);
        return redirect()->route('sales.index')->with('success', 'Sale updated.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted.');
    }
}

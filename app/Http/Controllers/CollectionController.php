<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Collector;
use App\Models\Supplier;
use App\Models\BottleType;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CollectionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view collections', only: ['index', 'show']),
            new Middleware('permission:create collections', only: ['create', 'store']),
            new Middleware('permission:edit collections', only: ['edit', 'update']),
            new Middleware('permission:delete collections', only: ['destroy']),
        ];
    }

    public function index()
    {
        $collections = Collection::with(['collector', 'supplier', 'bottleType'])
            ->latest()
            ->paginate(15);

        return view('collections.index', compact('collections'));
    }

    public function create()
    {
        $collectors  = Collector::all();
        $suppliers   = Supplier::where('is_active', true)->get();
        $bottleTypes = BottleType::all();

        return view('collections.create', compact('collectors', 'suppliers', 'bottleTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'collector_id'    => 'nullable|exists:collectors,id',
            'supplier_id'     => 'nullable|exists:suppliers,id',
            'bottle_type_id'  => 'required|exists:bottle_types,id',
            'collection_date' => 'required|date',
            'quantity'        => 'required|numeric|min:0.01',
            'unit_price'      => 'nullable|numeric|min:0',
            'paid'            => 'boolean',
            'notes'           => 'nullable|string',
        ]);

        // Ensure at least one source (collector or supplier) is selected
        if (empty($validated['collector_id']) && empty($validated['supplier_id'])) {
            return back()->withInput()->withErrors([
                'collector_id' => 'Please select either a Collector or a Supplier.',
            ]);
        }

        $validated['total_price'] = $validated['quantity'] * ($validated['unit_price'] ?? 0);

        $collection = Collection::create($validated);

        // Handle immediate payment if requested
        if ($request->has('pay_now') && $request->pay_now && $validated['unit_price'] > 0) {
            Payment::create([
                'payable_id'   => $collection->id,
                'payable_type' => Collection::class,
                'payment_date' => now(),
                'amount'       => $collection->total_price,
                'type'         => 'outgoing',
                'reference'    => $request->input('reference'),
                'notes'        => 'Payment for collection #' . $collection->id,
            ]);
            $collection->update(['paid' => true]);
        }

        return redirect()->route('collections.index')
                         ->with('success', 'Collection recorded successfully.');
    }

    public function show(Collection $collection)
    {
        $collection->load(['collector', 'supplier', 'bottleType', 'payments']);
        return view('collections.show', compact('collection'));
    }

    public function edit(Collection $collection)
    {
        $collectors  = Collector::all();
        $suppliers   = Supplier::where('is_active', true)->get();
        $bottleTypes = BottleType::all();

        return view('collections.edit', compact('collection', 'collectors', 'suppliers', 'bottleTypes'));
    }

    public function update(Request $request, Collection $collection)
{
    // Validate all fields except 'paid' (we handle it manually)
    $validated = $request->validate([
        'collector_id'    => 'nullable|exists:collectors,id',
        'supplier_id'     => 'nullable|exists:suppliers,id',
        'bottle_type_id'  => 'required|exists:bottle_types,id',
        'collection_date' => 'required|date',
        'quantity'        => 'required|numeric|min:0.01',
        'unit_price'      => 'nullable|numeric|min:0',
        'notes'           => 'nullable|string',
    ]);

    $validated['paid'] = $request->input('paid', 0) == 1 ? true : false;

    $validated['total_price'] = $validated['quantity'] * ($validated['unit_price'] ?? 0);

    if (empty($validated['collector_id']) && empty($validated['supplier_id'])) {
        return back()->withInput()->withErrors([
            'collector_id' => 'Please select either a Collector or a Supplier.',
        ]);
    }

    $collection->update($validated);

    return redirect()->route('collections.index')
                     ->with('success', 'Collection updated successfully.');
}

    public function destroy(Collection $collection)
    {
        $collection->delete();
        return redirect()->route('collections.index')
                         ->with('success', 'Collection deleted successfully.');
    }
}

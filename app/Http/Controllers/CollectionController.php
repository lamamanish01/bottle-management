<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Collector;
use App\Models\BottleType;
use App\Models\Payment;
use App\Http\Requests\StoreCollectionRequest;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::with(['collector', 'bottleType'])->latest()->paginate(15);
        return view('collections.index', compact('collections'));
    }

    public function create()
    {
        $collectors = Collector::all();
        $bottleTypes = BottleType::all();
        return view('collections.create', compact('collectors', 'bottleTypes'));
    }

    public function store(StoreCollectionRequest $request)
    {
        $validated = $request->validated();
        $validated['total_price'] = $validated['quantity'] * ($validated['unit_price'] ?? 0);
        $collection = Collection::create($validated);

        // If 'pay_now' is checked and unit_price is set, record payment to collector
        if ($request->has('pay_now') && $request->pay_now && $validated['unit_price'] > 0) {
            Payment::create([
                'payable_id' => $collection->id,
                'payable_type' => Collection::class,
                'payment_date' => now(),
                'amount' => $collection->total_price,
                'type' => 'outgoing',
                'reference' => $request->input('reference'),
                'notes' => 'Payment for collection #' . $collection->id,
            ]);
            $collection->update(['paid' => true]);
        }

        return redirect()->route('collections.index')->with('success', 'Collection recorded.');
    }

    public function show(Collection $collection)
    {
        $collection->load(['collector', 'bottleType', 'payments']);
        return view('collections.show', compact('collection'));
    }

    public function edit(Collection $collection)
    {
        $collectors = Collector::all();
        $bottleTypes = BottleType::all();
        return view('collections.edit', compact('collection', 'collectors', 'bottleTypes'));
    }

    public function update(StoreCollectionRequest $request, Collection $collection)
    {
        $validated = $request->validated();
        $validated['total_price'] = $validated['quantity'] * ($validated['unit_price'] ?? 0);
        $collection->update($validated);
        return redirect()->route('collections.index')->with('success', 'Collection updated.');
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();
        return redirect()->route('collections.index')->with('success', 'Collection deleted.');
    }
}

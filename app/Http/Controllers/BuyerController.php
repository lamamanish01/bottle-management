<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the buyers.
     */
    public function index()
    {
        $buyers = Buyer::latest()->paginate(10);
        return view('buyers.index', compact('buyers'));
    }

    /**
     * Show the form for creating a new buyer.
     */
    public function create()
    {
        return view('buyers.create');
    }

    /**
     * Store a newly created buyer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string|max:255',
        ]);

        Buyer::create($validated);

        return redirect()->route('buyers.index')
                         ->with('success', 'Buyer created successfully.');
    }

    /**
     * Display the specified buyer.
     */
    public function show(Buyer $buyer)
    {
        // Load related sales (optional)
        $buyer->load('sales.bottleType');
        return view('buyers.show', compact('buyer'));
    }

    /**
     * Show the form for editing the specified buyer.
     */
    public function edit(Buyer $buyer)
    {
        return view('buyers.edit', compact('buyer'));
    }

    /**
     * Update the specified buyer in storage.
     */
    public function update(Request $request, Buyer $buyer)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string|max:255',
        ]);

        $buyer->update($validated);

        return redirect()->route('buyers.index')
                         ->with('success', 'Buyer updated successfully.');
    }

    /**
     * Remove the specified buyer from storage.
     */
    public function destroy(Buyer $buyer)
    {
        // Optional: prevent deletion if there are related sales
        if ($buyer->sales()->count() > 0) {
            return redirect()->route('buyers.index')
                             ->with('error', 'Cannot delete buyer because they have sales records.');
        }

        $buyer->delete();

        return redirect()->route('buyers.index')
                         ->with('success', 'Buyer deleted successfully.');
    }
}

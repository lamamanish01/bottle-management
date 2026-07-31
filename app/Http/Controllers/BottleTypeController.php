<?php

namespace App\Http\Controllers;

use App\Models\BottleType;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BottleTypeController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view bottle-types', only: ['index', 'show']),
            new Middleware('permission:create bottle-types', only: ['create', 'store']),
            new Middleware('permission:edit bottle-types', only: ['edit', 'update']),
            new Middleware('permission:delete bottle-types', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the bottle types.
     */
    public function index()
    {
        $bottleTypes = BottleType::latest()->paginate(10);
        return view('bottle-types.index', compact('bottleTypes'));
    }

    /**
     * Show the form for creating a new bottle type.
     */
    public function create()
    {
        return view('bottle-types.create');
    }

    /**
     * Store a newly created bottle type in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:bottle_types,name',
            'unit'        => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        BottleType::create($validated);

        return redirect()->route('bottle-types.index')
                         ->with('success', 'Bottle type created successfully.');
    }

    /**
     * Display the specified bottle type (optional – show related collections & sales).
     */
    public function show(BottleType $bottleType)
    {
        // Load related collections and sales for statistics
        $bottleType->load(['collections', 'sales']);
        return view('bottle-types.show', compact('bottleType'));
    }

    /**
     * Show the form for editing the specified bottle type.
     */
    public function edit(BottleType $bottleType)
    {
        return view('bottle-types.edit', compact('bottleType'));
    }

    /**
     * Update the specified bottle type in storage.
     */
    public function update(Request $request, BottleType $bottleType)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:bottle_types,name,' . $bottleType->id,
            'unit'        => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $bottleType->update($validated);

        return redirect()->route('bottle-types.index')
                         ->with('success', 'Bottle type updated successfully.');
    }

    /**
     * Remove the specified bottle type from storage.
     */
    public function destroy(BottleType $bottleType)
    {
        // Prevent deletion if there are related collections or sales
        if ($bottleType->collections()->count() > 0 || $bottleType->sales()->count() > 0) {
            return redirect()->route('bottle-types.index')
                             ->with('error', 'Cannot delete this type because it is used in collections or sales.');
        }

        $bottleType->delete();

        return redirect()->route('bottle-types.index')
                         ->with('success', 'Bottle type deleted successfully.');
    }
}

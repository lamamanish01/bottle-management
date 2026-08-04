<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SupplierController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view suppliers', only: ['index', 'show']),
            new Middleware('permission:create suppliers', only: ['create', 'store']),
            new Middleware('permission:edit suppliers', only: ['edit', 'update']),
            new Middleware('permission:delete suppliers', only: ['destroy']),
        ];
    }

    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string|max:255',
            'tax_id'         => 'nullable|string|max:50',
            'payment_terms'  => 'nullable|string|max:100',
            'bank_name'      => 'nullable|string|max:255',
            'bank_account'   => 'nullable|string|max:255',
            'is_active'      => 'boolean',
            'notes'          => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Supplier::create($validated);

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load('collections');
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string|max:255',
            'tax_id'         => 'nullable|string|max:50',
            'payment_terms'  => 'nullable|string|max:100',
            'bank_name'      => 'nullable|string|max:255',
            'bank_account'   => 'nullable|string|max:255',
            'is_active'      => 'boolean',
            'notes'          => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->collections()->count() > 0) {
            return redirect()->route('suppliers.index')
                             ->with('error', 'Cannot delete supplier because they have collection records.');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier deleted successfully.');
    }
}

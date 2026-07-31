<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CollectorController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view collectors', only: ['index', 'show']),
            new Middleware('permission:create collectors', only: ['create', 'store']),
            new Middleware('permission:edit collectors', only: ['edit', 'update']),
            new Middleware('permission:delete collectors', only: ['destroy']),
        ];
    }

    public function index()
    {
        $collectors = Collector::latest()->paginate(10);
        return view('collectors.index', compact('collectors'));
    }

    public function create()
    {
        return view('collectors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        Collector::create($validated);
        return redirect()->route('collectors.index')->with('success', 'Collector created.');
    }

    public function show(Collector $collector)
    {
        return view('collectors.show', compact('collector'));
    }

    public function edit(Collector $collector)
    {
        return view('collectors.edit', compact('collector'));
    }

    public function update(Request $request, Collector $collector)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        $collector->update($validated);
        return redirect()->route('collectors.index')->with('success', 'Collector updated.');
    }

    public function destroy(Collector $collector)
    {
        $collector->delete();
        return redirect()->route('collectors.index')->with('success', 'Collector deleted.');
    }
}

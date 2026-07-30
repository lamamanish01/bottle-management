<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Collection;
use App\Models\Sale;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['payable'])->latest()->paginate(15);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payable_id'   => 'required|integer',
            'payable_type' => 'required|string',
            'payment_date' => 'required|date',
            'amount'       => 'required|numeric|min:0.01',
            'type'         => 'required|in:incoming,outgoing',
            'reference'    => 'nullable|string|max:255',
            'notes'        => 'nullable|string',
        ]);

        $payment = Payment::create($validated);
        $this->updateRelatedStatus($validated['payable_type'], $validated['payable_id']);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'payment' => $payment]);
        }

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load('payable');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_date' => 'required|date',
            'amount'       => 'required|numeric|min:0.01',
            'type'         => 'required|in:incoming,outgoing',
            'reference'    => 'nullable|string|max:255',
            'notes'        => 'nullable|string',
        ]);

        $payment->update($validated);
        $this->updateRelatedStatus($payment->payable_type, $payment->payable_id);

        return redirect()->route('payments.index')->with('success', 'Payment updated.');
    }

    public function destroy(Payment $payment)
    {
        $payableType = $payment->payable_type;
        $payableId   = $payment->payable_id;

        $payment->delete();
        $this->updateRelatedStatus($payableType, $payableId);

        return redirect()->route('payments.index')->with('success', 'Payment deleted.');
    }

    private function updateRelatedStatus(string $payableType, int $payableId)
    {
        if ($payableType === 'App\Models\Collection') {
            $collection = Collection::find($payableId);
            if ($collection) {
                $totalPaid = $collection->payments()->sum('amount');
                $collection->update(['paid' => $totalPaid >= $collection->total_price]);
            }
        } elseif ($payableType === 'App\Models\Sale') {
            $sale = Sale::find($payableId);
            if ($sale) {
                $totalPaid = $sale->payments()->sum('amount');
                if ($totalPaid >= $sale->total_price) {
                    $sale->update(['payment_status' => 'paid']);
                } elseif ($totalPaid > 0 && $totalPaid < $sale->total_price) {
                    $sale->update(['payment_status' => 'partial']);
                } else {
                    $sale->update(['payment_status' => 'pending']);
                }
            }
        }
    }
}

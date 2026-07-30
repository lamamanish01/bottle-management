<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'buyer_id' => 'required|exists:buyers,id',
            'bottle_type_id' => 'required|exists:bottle_types,id',
            'sale_date' => 'required|date',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0',
            'payment_status' => 'in:pending,partial,paid',
            'due_date' => 'nullable|date|after_or_equal:sale_date',
            'notes' => 'nullable|string',
        ];
    }
}

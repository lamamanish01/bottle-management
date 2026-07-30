<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust if you have auth checks
    }

    public function rules(): array
    {
        return [
            'collector_id' => 'required|exists:collectors,id',
            'bottle_type_id' => 'required|exists:bottle_types,id',
            'collection_date' => 'required|date',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'nullable|numeric|min:0',
            'paid' => 'boolean',
            'notes' => 'nullable|string',
        ];
    }
}

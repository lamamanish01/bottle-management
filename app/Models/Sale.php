<?php

namespace App\Models;

use App\Models\BottleType;
use App\Models\Buyer;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id', 'bottle_type_id', 'sale_date',
        'quantity', 'unit_price', 'total_price',
        'payment_status', 'due_date', 'notes'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function bottleType()
    {
        return $this->belongsTo(BottleType::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}

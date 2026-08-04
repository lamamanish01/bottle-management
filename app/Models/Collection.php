<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'collector_id',      // keep if you still use collectors
        'supplier_id',       // new supplier ID
        'bottle_type_id',
        'collection_date',
        'quantity',
        'unit_price',
        'total_price',
        'paid',
        'notes',
    ];

    // Existing relationship (keep if needed)
    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }

    // New supplier relationship
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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

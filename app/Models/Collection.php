<?php

namespace App\Models;

use App\Models\BottleType;
use App\Models\Collector;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'collector_id', 'bottle_type_id', 'collection_date',
        'quantity', 'unit_price', 'total_price', 'paid', 'notes'
    ];

    public function collector()
    {
        return $this->belongsTo(Collector::class);
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

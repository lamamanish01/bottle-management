<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payable_id', 'payable_type', 'payment_date',
        'amount', 'type', 'reference', 'notes'
    ];

    public function payable()
    {
        return $this->morphTo();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'tax_id',
        'payment_terms',
        'bank_name',
        'bank_account',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    // Accessors
    public function getStatusAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }
}

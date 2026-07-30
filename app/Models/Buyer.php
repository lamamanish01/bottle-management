<?php

namespace App\Models;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'contact_person', 'phone', 'email', 'address'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

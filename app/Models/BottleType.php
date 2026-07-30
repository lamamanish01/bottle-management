<?php

namespace App\Models;

use App\Models\Collection;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottleType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit', 'description'];

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

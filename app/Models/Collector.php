<?php

namespace App\Models;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'address'];

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}

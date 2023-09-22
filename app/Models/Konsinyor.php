<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsinyor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'telephone_number',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

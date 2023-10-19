<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Interact with the units's name
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtolower($value),
        );
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}

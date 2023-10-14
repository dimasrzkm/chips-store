<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'unit_id',
        'name',
        'purchase_date',
        'price',
        'total_price',
        'initial_stock',
        'remaining_stock',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    //

    /**
     * Interact with the stock's price
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => number_format($value, 0, ',', '.'),
            set: fn (string $value) => str_replace('.', '', $value),
        );
    }

    /**
     * Interact with the stock's total price
     */
    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => number_format($value, 0, ',', '.'),
            set: fn (string $value) => str_replace('.', '', $value),
        );
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class, 'expenses_detail', 'stock_id', 'expense_id')->withPivot('product_name', 'stock_name', 'total_used');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number_transaction',
        'transaction_code',
        'selling_date',
        'total',
        'nominal_payment',
        'nominal_return',
    ];

    protected $casts = [
        'selling_date' => 'date',
    ];

    /**
     * Interact with the stock's price
     */
    protected function total(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => str_replace('.', '', $value),
        );
    }

    /**
     * Interact with the stock's price
     */
    protected function nominalPayment(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => str_replace('.', '', $value),
        );
    }

    /**
     * Interact with the stock's price
     */
    protected function nominalReturn(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => str_replace('.', '', $value),
        );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sellings_detail', 'selling_id', 'product_id')->withPivot('product_name', 'quantity', 'sub_total', 'purchase_unit');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }
}

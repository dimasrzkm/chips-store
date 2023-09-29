<?php

namespace App\Models;

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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sellings_detail', 'selling_id', 'product_id')->withPivot('product_name', 'quantity', 'sub_total', 'purchase_unit');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

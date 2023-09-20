<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'initial_price',
        'percentage_profit',
        'sale_price',
        'stock',
    ];

    public function expenses()
    {
        return $this->belongsToMany(Expense::class, 'expenses_detail', 'product_id', 'expense_id')->withPivot('product_name', 'stock_name', 'total_used');
    }
}

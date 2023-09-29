<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number_transaction',
        'transaction_code',
        'expense_date',
    ];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stocks()
    {
        return $this->belongsToMany(Stock::class, 'expenses_detail', 'expense_id', 'stock_id')->withPivot('product_name', 'stock_name', 'total_used');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'expenses_detail', 'expense_id', 'product_id')->withPivot('product_name', 'stock_name', 'total_used');
    }
}

<?php

namespace App\Models;

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
        'initial_stock',
        'remaining_stock',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

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

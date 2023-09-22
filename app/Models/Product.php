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
        'konsinyor_id',
    ];

    public function konsinyor()
    {
        return $this->belongsTo(Konsinyor::class);
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class, 'expenses_detail', 'product_id', 'expense_id')->withPivot('product_name', 'stock_name', 'total_used');
    }

    public function consigments()
    {
        return $this->belongsToMany(Consigment::class, 'consigments_detail', 'product_id', 'consigment_id')->withPivot('product_name', 'konsinyor_name', 'total_consigment');
    }
}

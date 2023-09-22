<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consigment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number_transaction',
        'transaction_code',
        'consigment_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'consigments_detail', 'consigment_id', 'product_id')->withPivot('product_name', 'konsinyor_name', 'total_consigment');
    }
}

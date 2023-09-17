<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'name',
        'purchase_date',
        'price',
        'total',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

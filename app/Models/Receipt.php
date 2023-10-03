<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'selling_id',
        'name',
    ];

    public function selling()
    {
        return $this->belongsTo(Selling::class);
    }
}

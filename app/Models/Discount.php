<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_start',
        'discount_end',
        'product_id',
        'percentage',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

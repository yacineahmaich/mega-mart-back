<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'user_id',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

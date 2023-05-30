<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'user_id'
    ];

    public function items() {
        return $this->hasMany(Item::class);
    }

    public function customer() {
        return $this->belongsTo(User::class,'user_id');
    }
}

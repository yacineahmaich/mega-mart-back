<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'status',
        'total_price',
        'checkout_session_id',
        'name',
        'email',
        'phone',
        'shipping_address',
        'note',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

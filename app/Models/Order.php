<?php

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory, Uuids;

    protected $casts = [
        'delivered_at' => 'date',
        'paid_at' => 'date',
    ];

    protected $fillable = [
        'status',
        'total_price',
        'checkout_session_id',
        'checkout_url',
        'name',
        'email',
        'phone',
        'shipping_address',
        'note',
        'user_id',
        'delivered',
        'delivered_at',
        'paid_at',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function deleteUnpaidOrders($hours)
    {
        return Order::query()->where('status', 'unpaid')->where('created_at', '<', Carbon::now()->subHours($hours))->delete();
    }
}

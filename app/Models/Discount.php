<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Discount extends Model
{
    use HasFactory;

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
    ];

    protected $fillable = [
        'end',
        'product_id',
        'percentage',
    ];

    public function getPrice()
    {
        return number_format($this->product->price - ($this->product->price * $this->attributes['percentage'] / 100), 2);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function deleteOutdetedDiscounts()
    {
        return Discount::query()->where('end', '<=', Carbon::now())->delete();
    }
}

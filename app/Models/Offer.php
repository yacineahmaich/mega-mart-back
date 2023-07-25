<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
    ];

    protected $fillable = [
        'end',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public static function deleteOutdatedOffers()
    {
        return Offer::query()->where('end', '<=', Carbon::now())->delete();
    }
}

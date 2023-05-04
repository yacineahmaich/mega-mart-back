<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'description',
        'price',
        'quantity',
        'category_id'
    ];

    protected $allowedSorts = [
        'name',
        'price-desc',
        'price-asc',
        'newest',
        'oldest'
    ];

    public function scopeSortItems(Builder $query): void
    {
        if(!request()->has('sort')) return ;
        
        $sort_query = request('sort');

        if(!in_array($sort_query,$this->allowedSorts)) return;

        switch ($sort_query) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
        }
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }
}

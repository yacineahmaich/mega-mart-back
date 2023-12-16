<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public  function calcAvgRating()
    {
        $reviews = $this->reviews;
        $avg_rating = count($reviews) === 0 ? 5 : collect($reviews)->reduce(function ($sum, $review) {
            return $sum + $review['rating'];
        }, 0) / count($reviews);

        return number_format($avg_rating, 1);
    }

    public function getDiscountPrice()
    {
        $price = number_format($this->attributes['price'] - ($this->attributes['price'] * $this->discount->percentage / 100), 1);

        return $price;
    }

    public function hasDiscount()
    {
        return $this->discount !== null && $this->discount->end > Carbon::now();
    }


    protected $fillable = [
        'name',
        'slug',
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
        if (!request()->has('sort')) return;

        $sort_query = request('sort');

        if (!in_array($sort_query, $this->allowedSorts)) return;

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

    public function scopeFilter(Builder $query): void
    {
        // filter by category
        if (request()->has('cat')) {
            $categories = explode(',', request('cat'));

            $query->whereIn('category_id', $categories);
        }

        if (request()->has('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        if (request()->has('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        if (request()->has('rating')) {
            $query->join('reviews', 'products.id', '=', 'reviews.product_id')
                ->select('products.*')
                ->selectRaw('ROUND(AVG(reviews.rating), 1) as avg_rating')
                ->groupBy('products.id')
                ->havingRaw('FLOOR(avg_rating) = ?', [request('rating')]);
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public static function restoreProductsQuantity()
    {
        $soldoutProducts =  Product::query()->where('quantity', 0)->get();

        foreach ($soldoutProducts as $product) {
            $product->update(['quantity' => rand(1, 50)]);
            $product->save();
        }

        return count($soldoutProducts);
    }
}

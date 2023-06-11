<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\hasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, hasSlug;

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

        return $avg_rating;
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

        // if (request()->has('rating')) {
        //     $query->with('images')
        //         ->with('reviews')
        //         ->join('reviews', 'products.id', '=', 'reviews.product_id')
        //         ->groupBy('products.id')
        //         ->havingRaw('CEIL(AVG(reviews.rating)) = ?', [request('rating')]);
        // }
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

    public function offer()
    {
        return $this->hasOne(Offer::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class MainCategory extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable', null, 'imageable_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dsecription'
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable', null, 'imageable_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}

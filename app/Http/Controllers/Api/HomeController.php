<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainCategoryCollection;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\ProductCollection;
use App\Models\MainCategory;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function offers()
    {
        return new OfferCollection(Offer::all());
    }

    public function mCategories()
    {
        return new MainCategoryCollection(MainCategory::all());
    }

    public function mCategoryProducts(MainCategory $mainCategory)
    {
        $categoryIds = $mainCategory->categories->pluck('id')->toArray();


        $products = Product::withCount('reviews')
            ->whereIn('category_id', $categoryIds)
            ->orderBy('reviews_count', 'desc')
            ->paginate(12);

        return new ProductCollection($products);
    }
}

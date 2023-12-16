<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\MainCategoryResource;
use App\Http\Resources\ProductCollection;
use App\Models\MainCategory;
use App\Models\Product;


class FeedController extends Controller
{
    public function index()
    {
        $main_categories = MainCategory::take(10)->get();

        $feed = [];
        foreach ($main_categories as $mc) {
            $categories = $mc->categories->pluck('id')->toArray();
            $products = Product::withCount('reviews')
                ->whereIn('category_id', $categories)
                ->orderBy('reviews_count', 'desc')
                ->take(12)
                ->get();

            $feed[] = [
                'mainCategory' => new MainCategoryResource($mc),
                'products' => new ProductCollection($products)
            ];
        }

        return [
            'feed' => $feed,
        ];
    }


    public function mainCategoryFeed(MainCategory $mainCategory)
    {
        $feed = [];
        $categories = $mainCategory->categories;

        foreach ($categories as $category) {
            $products = Product::withCount('reviews')
                ->where('category_id', $category->id)
                ->orderBy('reviews_count', 'desc')
                ->take(12)
                ->get();
            $feed[] = [
                'category' => new CategoryResource($category),
                'products' => new ProductCollection($products)
            ];
        }

        return [
            'mainCategory' => new MainCategoryResource($mainCategory),
            'feed' => $feed
        ];
    }
}

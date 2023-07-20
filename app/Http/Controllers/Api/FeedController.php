<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainCategoryResource;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\ProductCollection;
use App\Models\MainCategory;
use App\Models\Offer;
use App\Models\Product;


class FeedController extends Controller
{
    public function index()
    {
        $offers = new OfferCollection(Offer::all());

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
            'offers' => $offers,
            'feed' => $feed,
        ];
    }
}

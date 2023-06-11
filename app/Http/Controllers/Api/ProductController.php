<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewCollection;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $allowedPaginationLimits = [10, 15, 20];

    public function index(Request $request)
    {
        $limit = $request->query('limit') ?? 10;
        $limit = in_array($limit, $this->allowedPaginationLimits) ? $limit : 10;

        return new ProductCollection(Product::filter()->sortItems()->paginate($limit));
    }

    public function byIds(Request $request)
    {
        $ids = $request->query('productIds');
        $ids = $ids ? explode(',', $ids) : [];
        return new ProductCollection(Product::find($ids));
    }

    public function categoryProducts(Request $request, Category $category)
    {
        $limit = $request->query('limit') ?? 10;
        $limit = in_array($limit, $this->allowedPaginationLimits) ? $limit : 10;

        $one_page = $request->query('one-page') ?? false;

        if ($one_page) {
            return new ProductCollection($category->products->take(12));
        }

        // Get products by ids
        if ($request->has('productIds')) {
            $ids = $request->query('productIds');
            $ids = $ids ? explode(',', $ids) : [];
            return new ProductCollection($category->products->whereIn($ids, 'id')->get());
        }

        return new ProductCollection($category->products()->filter()->sortItems()->paginate($limit));
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


    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function getReviews($id)
    {
        return new ReviewCollection(Review::where('product_id', $id)->get());
    }
}

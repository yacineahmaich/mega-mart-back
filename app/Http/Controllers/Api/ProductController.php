<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $allowedPaginationLimits = [10, 15, 20];

    public function categoryHotProducts(Category $category)
    {
        return new ProductCollection($category->products()->take(12)->get());
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

        return new ProductCollection($category->products()->filter()->sortItems()->paginate($limit));
    }


    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function getReviews($id)
    {
        return new ReviewCollection(Review::where('product_id', $id)->latest()->paginate(6));
    }

    public function storeReview(StoreReviewRequest $request, $id)
    {
        $review = Review::create([
            'rating' => $request->validated('rating'),
            'comment' => $request->validated('comment'),
            'user_id' => $request->user()->id,
            'product_id' => $id
        ]);

        return new ReviewResource($review);
    }


    public function search(Request $request)
    {
        $query = $request->query('q');

        if (!$query) {
            return new ProductCollection([]);
        }

        $result = Product::query()->where('name', 'like', "%$query%")->withCount('reviews')->orderBy('reviews_count')->take(4)->get();

        return new ProductCollection($result);
    }
}

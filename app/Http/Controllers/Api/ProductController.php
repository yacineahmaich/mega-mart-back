<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewCollection;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $allowedPaginationLimits = [10, 15, 20];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit') ?? 10;
        $limit = in_array($limit, $this->allowedPaginationLimits) ? $limit : 10;

        // Get products by ids
        if ($request->has('productIds')) {
            $ids = $request->query('productIds');
            $ids = $ids ? explode(',', $ids) : [];
            return new ProductCollection(Product::find($ids));
        }

        return new ProductCollection(Product::filter()->sortItems()->paginate($limit));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function getReviews($id)
    {
        return new ReviewCollection(Review::where('product_id', $id)->get());
    }
}

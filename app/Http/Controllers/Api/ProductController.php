<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $allowedPaginationLimits = [10,15,20];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit') ?? 10;
        $limit = in_array($limit, $this->allowedPaginationLimits) ? $limit : 10;

        return ProductResource::collection(Product::filter()->sortItems()->paginate($limit));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}

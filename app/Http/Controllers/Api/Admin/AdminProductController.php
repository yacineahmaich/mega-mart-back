<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ReviewCollection;
use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProductCollection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = DB::transaction(function () use ($request) {
            $data = $request->validated();
            $product = Product::create($data);

            foreach ($data['images'] as $image) {

                $imageName = time() . '_' . $image->getClientOriginalName();

                $url = $image->store('images/products', 'public');

                $product->images()->save(
                    Image::create([
                        'name' => $imageName,
                        'url' => url('storage/' . $url),
                    ])
                );
            }

            return $product;
        });


        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $updated_product = DB::transaction(function () use ($data, $product, $request) {

            $product = tap($product)->update($data);

            if ($request->has('images') && !empty($data['images'])) {
                foreach ($data['images'] as $image) {

                    $imageName = time() . '_' . $image->getClientOriginalName();

                    $url = $image->store('images/products', 'public');

                    $product->images()->save(
                        Image::create([
                            'name' => $imageName,
                            'url' => url('storage/' . $url),
                        ])
                    );
                }
            }

            return $product;
        });

        return new ProductResource($updated_product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $is_deleted = $product->delete();

        return response()->json([
            'success' => $is_deleted
        ]);
    }

    public function getReviews($id)
    {
        return new ReviewCollection(Review::where('product_id', $id)->paginate());
    }

    public function deleteImage(Product $product, Image $image)
    {
        $images_count = $product->images()->count();

        if ($images_count === 1) return response()->json([
            "message" => 'cannot delete all product image (a thumbnail image is required)'
        ], 402);


        $image->delete();

        return response()->json([
            "success" => true
        ]);
    }
}

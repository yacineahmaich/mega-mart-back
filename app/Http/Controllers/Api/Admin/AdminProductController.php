<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\ProductCollection;
use App\Models\Image;
use App\Models\Product;
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
        $product = DB::transaction(function() use ($request) {
            $data= $request->validated();
            $product = Product::create($data);

            foreach($data['images'] as $image) {
                
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                $url = $image->store('images/products', 'public');
                
                Image::create([
                    'name' => $imageName,
                    'url' => url('storage/'. $url),
                    'product_id' => $product->id
                ]);
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
    public function update(UpdateProductRequest $request, string $id)
    {
        //
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
}

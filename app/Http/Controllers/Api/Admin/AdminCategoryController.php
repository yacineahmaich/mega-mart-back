<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return new CategoryCollection(Category::paginate());
        } else {
            return new CategoryCollection(Category::all());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = DB::transaction(function () use ($request) {


            $data = $request->except(['image']);
            $image = $request->validated('image');

            $category = Category::create($data);

            $imageName = time() . '_' . $image->getClientOriginalName();

            $url = $image->store('images/categories', 'public');

            $category->image()->save(
                Image::create([
                    'name' => $imageName,
                    'url' => url('storage/' . $url),
                ])
            );

            return $category;
        });

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = DB::transaction(function () use ($request, $category) {
            $data = $request->safe()->except(['image']);
            $image = $request->validated('image');

            $updatedCategory = tap($category)->update($data);

            if (!empty($image)) {
                $imageName = time() . '_' . $image->getClientOriginalName();

                $url = $image->store('images/categories', 'public');

                $updatedCategory->image()->delete();

                $updatedCategory->image()->save(
                    Image::create([
                        'name' => $imageName,
                        'url' => url('storage/' . $url),
                    ])
                );
            }

            return $updatedCategory;
        });

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $id_deleted = $category->delete();
        return response()->json([
            'success' => $id_deleted
        ]);
    }
}

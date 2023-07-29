<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMainCategoryRequest;
use App\Http\Requests\Admin\UpdateMainCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\MainCategoryCollection;
use App\Http\Resources\MainCategoryResource;
use App\Models\Image;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMainCategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return new MainCategoryCollection(MainCategory::paginate());
  }


  public function all()
  {
    return new MainCategoryCollection(MainCategory::all());
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreMainCategoryRequest $request)
  {
    $main_category = DB::transaction(function () use ($request) {


      $data = $request->safe()->except(['image']);
      $image = $request->validated('image');

      $main_category = MainCategory::create($data);

      $imageName = time() . '_' . $image->getClientOriginalName();

      $url = $image->store('images/main-categories', 'public');

      $main_category->image()->save(
        Image::create([
          'name' => $imageName,
          'url' => url('storage/' . $url),
        ])
      );

      return $main_category;
    });

    return new CategoryResource($main_category);
  }

  /**
   * Display the specified resource.
   */
  public function show(MainCategory $mainCategory)
  {
    return new MainCategoryResource($mainCategory);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateMainCategoryRequest $request, MainCategory $mainCategory)
  {
    $main_category = DB::transaction(function () use ($request, $mainCategory) {
      $data = $request->safe()->except(['image']);
      $image = $request->validated('image');

      $updated_main_category = tap($mainCategory)->update($data);

      if (!empty($image)) {
        $imageName = time() . '_' . $image->getClientOriginalName();

        $url = $image->store('images/main-categories', 'public');

        $updated_main_category->image()->delete();

        $updated_main_category->image()->save(
          Image::create([
            'name' => $imageName,
            'url' => url('storage/' . $url),
          ])
        );
      }

      return $updated_main_category;
    });

    return new MainCategoryResource($main_category);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(MainCategory $mainCategory)
  {
    $id_deleted = $mainCategory->delete();
    return response()->json([
      'success' => $id_deleted
    ]);
  }
}

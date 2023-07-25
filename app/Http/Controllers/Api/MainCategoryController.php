<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainCategoryCollection;
use App\Http\Resources\MainCategoryResource;
use App\Models\MainCategory;

class MainCategoryController extends Controller
{
    public function index()
    {
        return new MainCategoryCollection(MainCategory::all());
    }

    public function show(MainCategory $mainCategory)
    {
        return new MainCategoryResource($mainCategory);
    }
}

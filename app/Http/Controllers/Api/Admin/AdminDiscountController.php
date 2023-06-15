<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDiscountRequest;
use App\Http\Requests\Admin\UpdateDiscountRequest;
use App\Http\Resources\DiscountCollection;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;

class AdminDiscountController extends Controller
{
    public function index()
    {

        return new DiscountCollection(Discount::paginate());
    }

    public function apply(StoreDiscountRequest $request)
    {
        $discount = Discount::create($request->validated());

        return new DiscountResource($discount);
    }

    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $updatedDiscount = tap($discount)->updateOrFail($request->validated());

        return response()->json([
            'success' => $updatedDiscount
        ]);
    }

    public function show(Discount $discount)
    {
        return new DiscountResource($discount);
    }

    public function delete(Discount $discount)
    {
        $discount->deleteOrFail();

        return response()->json([
            'success' => true
        ]);
    }
}

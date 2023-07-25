<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOfferRequest;
use App\Http\Requests\Admin\UpdateOfferRequest;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferResource;
use App\Models\Image;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;

class AdminOfferController extends Controller
{
    public function index()
    {
        return new OfferCollection(Offer::paginate());
    }

    public function store(StoreOfferRequest $request)
    {
        $data = $request->safe()->except('backdrop');
        $backdrop = $request->validated('backdrop');

        $offer = DB::transaction(function () use ($data, $backdrop) {
            $offer = Offer::create($data);

            $imageName = time() . '_' . $backdrop->getClientOriginalName();

            $url = $backdrop->store('images/offers', 'public');

            $offer->image()->save(
                Image::create([
                    'name' => $imageName,
                    'url' => url('storage/' . $url),
                ])
            );

            return $offer;
        });


        return new OfferResource($offer);
    }

    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer = DB::transaction(function () use ($request, $offer) {
            $data = $request->safe()->except(['backdrop']);
            $image = $request->validated('backdrop');

            $updatedOffer = tap($offer)->updateOrFail($data);

            if (!empty($image)) {
                $imageName = time() . '_' . $image->getClientOriginalName();

                $url = $image->store('images/offers', 'public');

                $updatedOffer->image()->delete();

                $updatedOffer->image()->save(
                    Image::create([
                        'name' => $imageName,
                        'url' => url('storage/' . $url),
                    ])
                );
            }

            return $updatedOffer;
        });

        return new OfferResource($offer);
    }

    public function show(Offer $offer)
    {
        return new OfferResource($offer);
    }

    public function destroy(Offer $offer)
    {
        $is_deleted = $offer->deleteOrFail();

        return response()->json([
            'success' => $is_deleted
        ]);
    }
}

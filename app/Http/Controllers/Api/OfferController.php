<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferCollection;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        return new OfferCollection(Offer::all());
    }
}
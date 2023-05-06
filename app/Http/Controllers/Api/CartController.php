<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function addToCart(Request $request, Product $product)
    {
        if (Auth::user()) {
            if ($product->quantity < $request->input("quantity")) {
                return response()->json(["message" => "quantity not valid"]);
            } else {
                $product = $request->session()->get("products");
                $product[$product->id] = $request->input("quantity");
                $request->session()->put("products", $product);
                return response()->json(["message" => "product add to cart successefuly"],201)
                ;
            }
        }else {
            return response()->json(["message" => "user no authentifier"]);

        }
    }


}

//}

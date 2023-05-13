<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function signup(SignupRequest $request)
    {
        $credentials = $request->validated();

        $user = User::create([
            'name' => $credentials["name"],
            'email' => $credentials["email"],
            'password' => Hash::make($credentials["password"])
        ]);

        $customer = Customer::create([
            'user_id' => $user->id,
        ]);

        return response()->json([
            'token' => $user->createToken("token")->plainTextToken,
            "profile" => new CustomerResource($customer)
        ], 201);
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->safe()->only(["email", "password"]);
        $remember = $request->remember ?? false;

        if (!Auth::attempt($credentials, $remember)) {
            return response()->json([
                'message' => 'invalid credentials',
            ], 401);
        }

        /** @var User */
        $user = Auth::user();
        $token = $user->createToken("token")->plainTextToken;

        return response()->json([
            'token' => $token,
            "profile" => new CustomerResource($user->customer)
        ], 200);

    }
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();
        
        return response()->json(["success" => true],200) ;
    }


    public function me(Request $request)
    {
        return new CustomerResource($request->user()->customer);
    }

}
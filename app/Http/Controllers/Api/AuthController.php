<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function signup(SignupRequest $request)
    {
        //Validated

        $credentials = $request->validated();



        $user = User::create([
            'name' => $credentials["name"],
            'email' => $credentials["email"],
            'password' => Hash::make($credentials["password"])
        ]);

        return response()->json([

            'message' => "User Created Successfully",
            'token' => $user->createToken("main")->plainTextToken,
            "user" => new UserResource($user)
        ], 200);



    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->safe()->only(["email", "password"]);
        $remember_me = $request->rememberme ?? false;

        if (!Auth::attempt($credentials, $remember_me)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        /** @var User */
        $user = Auth::user();
        $token = $user->createToken("main")->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => "logged in successfully as $user->email",
            'token' => $token,
            "user" => new UserResource($user)
        ], 200);

    }
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();
        
        return response()->json(["message" => "logout"],200) ;
    }
    public function me(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
      
        
        return new UserResource($user) ;
    }

}
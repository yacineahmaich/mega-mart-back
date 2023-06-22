<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            "name" => $user->name,
            "email" => $user->email,
            "identifier" => $user->id,
            "totalOrders" => $user->orders()->count(),
            "spentedAmount" => $user->orders()->sum('total_price'),
            "joinAt" => $user->created_at->format('Y/m/d')
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $request->user()->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
        } else {
            $request->user()->update($data);
        }

        return new UserResource($request->user());
    }

    public function updateProfileImage(Request $request)
    {
    }
}

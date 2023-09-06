<?php

namespace App\Services;

use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountService
{

    public function getUserProfile(Request $request)
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


    public function updateUserProfile(UpdateProfileRequest $request)
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
    }

    public function changeUserAvatar(UpdateAvatarRequest $request)
    {
        $image = $request->validated('image');

        $user =  $request->user();

        $imageName = time() . '_' . $image->getClientOriginalName();

        $url = $image->store('images/users', 'public');


        DB::beginTransaction();
        $user->avatar()->delete();
        $user->avatar()->save(
            Image::create([
                'name' => $imageName,
                'url' => url('storage/' . $url),
            ])
        );
        DB::commit();
    }
}

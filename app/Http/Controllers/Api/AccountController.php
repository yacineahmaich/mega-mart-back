<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function getProfile() {

    }

    public function updateProfile(UpdateProfileRequest $request) {
        $data = $request->validated();

        if(isset($data['password'])) {
            $request->user()->update([
             'name' => $data['name'],
            //  'email' => $data['email'],
             'password' => bcrypt($data['password'])
            ]);

            return new UserResource($request->user());

        } else {
            $request->user()->update($data);

            return new UserResource($request->user());
        }
    }
}

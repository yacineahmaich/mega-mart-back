<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function getProfile(Request $request) {
        
    }

    public function updateProfile(UpdateProfileRequest $request) {
        $data = $request->validated();

        if(isset($data['password'])) {
            $request->user()->update([
             'name' => $data['name'],
            //  'email' => $data['email'],
             'password' => bcrypt($data['password'])
            ]);

            return new CustomerResource($request->user()->customer);

        } else {
            $request->user()->update($data);

            return new CustomerResource($request->user()->customer);
        }
    }

    public function updateProfileImage(Request $request) {
        
    }
}

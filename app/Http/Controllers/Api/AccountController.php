<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(
        protected AccountService $service
    ) {
    }


    public function getProfile(Request $request)
    {
        return $this->service->getUserProfile($request);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {

        $this->service->updateUserProfile($request);

        return new UserResource($request->user());
    }

    public function setAvatar(UpdateAvatarRequest $request)
    {
        $this->service->changeUserAvatar($request);

        return response()->json([
            'success' => true
        ]);
    }
}

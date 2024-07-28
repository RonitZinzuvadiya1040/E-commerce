<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Password\UpdatePasswordRequest;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function userProfile()
    {
        return $this->profileService->getUserProfileView();
    }

    public function adminProfile()
    {
        return $this->profileService->getAdminProfileView();
    }

    public function managerProfile()
    {
        return $this->profileService->getManagerProfileView();
    }

    public function update(UpdateProfileRequest $request)
    {
        return $this->profileService->updateProfile($request);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        return $this->profileService->updatePassword($request);
    }
}

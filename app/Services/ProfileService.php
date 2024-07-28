<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileService
{
    public function getUserProfileView()
    {
        return view('user.profile');
    }

    public function getAdminProfileView()
    {
        return view('admin.profile');
    }

    public function getManagerProfileView()
    {
        return view('manager.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return $this->getRedirectRoute($user->type, 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->newpassword);
            $user->save();

            return $this->getRedirectRoute($user->type, 'Password updated successfully.');
        } else {
            return back()->withErrors(['password' => 'The provided old password does not match our records.']);
        }
    }

    private function getRedirectRoute($userType, $message)
    {
        $redirectRoute = match ($userType) {
            'admin' => 'admin.profile',
            'manager' => 'manager.profile',
            default => 'user.profile',
        };

        return redirect()->route($redirectRoute)->with('status', $message);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $input = $request->all();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        # Check if the email exists in the database
        $user = User::where('email', $input['email'])->first();

        if (!$user) {
            # If the email does not exist, return with an error message
            return redirect()->route('login')->with('error', 'The provided email does not exist.');
        }

        # Check if the provided password matches the stored password
        if (!Hash::check($input['password'], $user->password)) {
            # If the password does not match, return with an error message
            return redirect()->route('login')->with('error', 'The provided password is incorrect.');
        }

        # If both email and password are correct, log in the user
        auth()->login($user);

        switch ($user->type) {
            case 'admin':
                return redirect()->route('admin.home');
            case 'manager':
                return redirect()->route('manager.home');
            default:
                return redirect()->route('user.home');
        }
    }
}

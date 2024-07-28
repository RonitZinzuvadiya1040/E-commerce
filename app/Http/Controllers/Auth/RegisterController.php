<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('throttle:6,1')->only('register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => ['required', 'integer', 'between:0,2'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'type' => $data['type'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        Log::info('Register method called'); // Log the entry into the method

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        Log::info('Registered event fired');

        // $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    protected function registered(Request $request, $user)
    {
        return redirect()->route('verification.notice');
    }
}

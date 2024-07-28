<?php
namespace App\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => 'required|string|min:6',
            'newpassword' => 'required|string|min:6|confirmed|different:password',
            'newpassword_confirmation' => 'required|string|min:6|same:newpassword',
        ];
    }
}

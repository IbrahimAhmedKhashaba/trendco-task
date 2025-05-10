<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->provider) {
            $data = [
                'code' => 'required|string',
            ];
        } else {
            $data = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_admin' => 'nullable|in:0,1',
            ];
        }
        return $data;
    }
}

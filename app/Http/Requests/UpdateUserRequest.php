<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:80',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'mobile_phone' => 'nullable|regex:/^[0-9]{9}$/',
            'adress_1' => 'nullable|max:255',
            'adress_2' => 'nullable|max:255',
            'level' => 'required|integer|min:1|max:3',
            'points' => 'required|integer|min:0',
            'email_confirmed' => 'required|boolean',
            'activated' => 'required|boolean',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Пожалуйста, укажите адрес электронной почты.',
            'email.email' => 'Пожалуйста, укажите корректный адрес электронной почты.',
            'password.required' => 'Пароль обязателен для входа.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Валидация не прошла',
            'errors' => $validator->errors(),
        ], 422));
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ваше имя обязательно.',
            'email.required' => 'Адрес электронной почты обязателен.',
            'email.email' => 'Пожалуйста, укажите корректный адрес электронной почты.',
            'email.unique' => 'Этот адрес электронной почты уже зарегистрирован.',
            'password.required' => 'Пароль обязателен.',
            'password.min' => 'Пароль должен содержать не менее 6 символов.',
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

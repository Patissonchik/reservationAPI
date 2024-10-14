<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'check_in_date' => 'required|date',
            'status' => 'required|in:confirmed,pending'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'ID пользователя обязателен для бронирования.',
            'user_id.exists' => 'Пользователя с указанным ID не существует.',
            'check_in_date.required' => 'Дата заезда обязательна.',
            'check_in_date.date' => 'Дата заезда должна быть корректной датой.',
            'status.required' => 'Статус бронирования обязателен.',
            'status.in' => 'Статус должен быть либо "confirmed", либо "pending".',
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'check_in_date' => 'nullable|date',
            'status' => 'nullable|in:confirmed,pending'
        ];
    }

    public function messages()
    {
        return [
            'check_in_date.date' => 'Дата заезда должна быть корректной датой.',
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

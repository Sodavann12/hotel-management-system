<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id'          => ['required', 'exists:rooms,id'],
            'user_id'          => ['required', 'exists:users,id'],
            'check_in'         => ['required', 'date', 'after_or_equal:today'],
            'check_out'        => ['required', 'date', 'after:check_in'],
            'guests'           => ['required', 'integer', 'min:1', 'max:10'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'check_in.after_or_equal' => 'Check-in date cannot be in the past.',
            'check_out.after'         => 'Check-out must be at least one night after check-in.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_type_id' => ['required', 'exists:room_types,id'],
            'number'       => ['required', 'string',
                               Rule::unique('rooms', 'number')->ignore($this->room)],
            'floor'        => ['required', 'integer', 'min:1', 'max:50'],
            'status'       => ['required', 'in:available,reserved,occupied,dirty,maintenance,out_of_order'],
            'notes'        => ['nullable', 'string', 'max:500'],
        ];
    }
}
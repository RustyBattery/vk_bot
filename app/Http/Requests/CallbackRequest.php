<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CallbackRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required|string',
            'object' => 'required|array',
            'group_id' => 'required|integer',
        ];
    }
}

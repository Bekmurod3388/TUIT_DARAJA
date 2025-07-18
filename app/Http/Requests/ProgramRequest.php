<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'program_name_id' => 'required|exists:program_names,id',
            'price' => 'required|integer|min:0',
            'description' => 'required|string',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,fan_id',
            'is_visible' => 'nullable|boolean',
        ];
    }
} 
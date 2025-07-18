<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'specalization_id' => 'required|exists:specalizations,id',
            'chairman' => 'required|string|max:255',
            'deputy' => 'required|string|max:255',
            'secretary' => 'required|string|max:255',
            'members' => 'required', // JSON yoki array sifatida tekshirish mumkin
        ];
    }
} 
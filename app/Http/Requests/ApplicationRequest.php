<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'specalization_id' => 'required|exists:specalizations,id',
            'education_type' => 'required|string|max:255',
            'organization_type' => 'required|in:uzmu,other',
            'subject' => 'required|string|max:255',
        ];
        if ($this->organization_type === 'other') {
            $rules['organization'] = 'nullable|string|max:255';
            $rules['phone'] = 'nullable|string|max:32';
            $rules['oac_file'] = 'nullable|file|mimes:pdf|max:2048';
            $rules['direction_file'] = 'required|file|mimes:pdf|max:2048';
            $rules['receipt_file'] = 'required|file|mimes:pdf,jpeg|max:2048';
        } else {
            $rules['organization'] = 'nullable|string|max:255';
            $rules['phone'] = 'nullable|string|max:32';
            $rules['oac_file'] = 'nullable|file|mimes:pdf|max:2048';
            $rules['work_order_file'] = 'nullable|file|mimes:pdf|max:2048';
        }
        return $rules;
    }
}

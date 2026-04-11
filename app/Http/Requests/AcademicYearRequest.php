<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcademicYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $academicYearId = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('academic_years', 'name')
                    ->where(fn ($query) => $query->where('semester', $this->input('semester')))
                    ->ignore($academicYearId),
            ],
            'semester' => [
                'required',
                Rule::in(\App\Models\AcademicYear::SEMESTERS),
            ],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}

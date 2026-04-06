<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $members = $this->input('members');

        if (is_string($members)) {
            $members = preg_split('/[\r\n,]+/', $members) ?: [];

            $this->merge([
                'members' => array_values(array_filter(array_map('trim', $members))),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'specalization_id' => 'required|exists:specalizations,id',
            'chairman' => 'required|string|max:255',
            'deputy' => 'required|string|max:255',
            'secretary' => 'required|string|max:255',
            'members' => 'required|array|min:1',
            'members.*' => 'required|string|max:255',
        ];
    }
}

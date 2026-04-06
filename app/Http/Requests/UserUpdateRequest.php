<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $targetUser = User::find($this->route('id'));

        return $targetUser !== null && $this->user()?->can('update', $targetUser) === true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => User::normalizePhone($this->input('phone')),
        ]);
    }

    public function rules(): array
    {
        $allowedRoles = $this->user()?->role === 'superadmin'
            ? ['user', 'admin', 'superadmin']
            : ['user'];

        return [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max:32',
                Rule::unique('users', 'phone')->ignore($this->route('id')),
            ],
            'role' => ['required', Rule::in($allowedRoles)],
        ];
    }
}

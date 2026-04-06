<?php

namespace App\Http\Requests;

use App\Models\Application;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        $application = Application::find($this->route('id'));

        return $application && $this->user() && $application->user_id === $this->user()->id;
    }

    public function rules()
    {
        return [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'specalization_id' => 'required|exists:specalizations,id',
            'subject' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
        ];
    }
}

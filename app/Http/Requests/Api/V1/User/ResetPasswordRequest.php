<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => [Rule::requiredIf($this->user()->password !== null), 'current_password:web'],
            'new_password' => ['required', 'different:current_password', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()]
        ];
    }
}

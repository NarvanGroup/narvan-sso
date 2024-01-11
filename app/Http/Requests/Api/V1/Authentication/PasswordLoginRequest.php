<?php

namespace App\Http\Requests\Api\V1\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class PasswordLoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required','ir_mobile:zero','exists:users'],
            'password' => ['required','string','min:8','max:255']
        ];
    }
}

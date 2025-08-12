<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'email_verified_at' => ['nullable'],
            'password' => ['required', 'confirmed', Password::min(4)->letters()],
            'remember_token' => ['nullable', 'string', 'max:100'],
        ];
    }
}

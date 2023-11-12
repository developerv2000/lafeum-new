<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{

    protected $redirect = '/profile/edit#password-update-section';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.current_password' => 'Неверный пароль',
        ];
    }
}

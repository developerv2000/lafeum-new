<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'photo' => ['file', File::types(['png', 'jpg', 'jpeg']), 'nullable'],
            'name' => ['string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'country_id' => ['integer', 'numeric', 'min:1', 'nullable'],
            'birthday' => ['date', 'max:255', 'nullable'],
            'gender_id' => ['integer', 'numeric', 'min:1', 'nullable'],
            'biography' => []
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Пользователь с таким именем уже существует',
            'email.unique' => 'Пользователь с такой почтой уже существует',
        ];
    }
}

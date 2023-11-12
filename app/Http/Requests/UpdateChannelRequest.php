<?php

namespace App\Http\Requests;

use App\Models\Channel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChannelRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255', Rule::unique(Channel::class)->ignore($this->id)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Канал с таким именем уже существует',
        ];
    }
}

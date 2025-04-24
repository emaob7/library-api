<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'birthdate' => 'sometimes|date|before_or_equal:today',
            'nationality' => 'sometimes|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'birthdate.before_or_equal' => 'La fecha de nacimiento no puede ser futura.',
        ];
    }
}

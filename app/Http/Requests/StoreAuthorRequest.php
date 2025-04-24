<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date|before_or_equal:today',
            'nationality' => 'required|string|max:100',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del autor es obligatorio.',
            'birthdate.before_or_equal' => 'La fecha de nacimiento no puede ser futura.',
            'nationality.required' => 'La nacionalidad es obligatoria.',
        ];
    }
}

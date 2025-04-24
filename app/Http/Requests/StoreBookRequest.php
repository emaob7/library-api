<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn|max:20',
            'published_date' => 'required|date|before_or_equal:today',
            'author_id' => 'required|exists:authors,id',
        ];
    }


    public function messages(): array
    {
        return [
            'title.required' => 'El título del libro es obligatorio.',
            'isbn.unique' => 'El ISBN ya está registrado.',
            'published_date.before_or_equal' => 'La fecha de publicación no puede ser futura.',
            'author_id.exists' => 'El autor seleccionado no existe.',
        ];
    }
}

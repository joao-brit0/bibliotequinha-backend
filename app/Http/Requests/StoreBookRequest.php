<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'min:1500', 'max:' . date('Y')],
            'publisher_id' => ['required', 'exists:publishers,id'], // Garante que a editora exista no banco
            'theme_id' => ['required', 'exists:themes,id'],
            'isbn' => ['required', 'string', 'unique:books,isbn'], // Garante que o ISBN não seja duplicado
            'quantity' => ['nullable', 'integer', 'min:1'],
            'number_of_pages' => ['nullable', 'integer', 'min:1'],
            'cutter_code' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'authors' => ['required', 'array', 'min:1'], // Exige no mínimo 1 autor
            'authors.*' => ['exists:authors,id'], // Valida cada ID de autor enviado
        ];
    }
}

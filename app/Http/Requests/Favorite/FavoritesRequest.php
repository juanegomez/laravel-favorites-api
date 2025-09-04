<?php

namespace App\Http\Requests\Favorite;

use App\Http\Requests\BaseRequest;

class FavoritesRequest extends BaseRequest
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
            'search' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'per_page' => ['nullable', 'numeric', 'min:1', 'max:20'],
            'page' => ['nullable', 'numeric', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'search.max' => 'El término de búsqueda no debe superar los 255 caracteres.',
            'name.max' => 'El nombre no debe superar los 255 caracteres.',
            'description.max' => 'La descripción no debe superar los 255 caracteres.',
            'per_page.numeric' => 'El número de elementos por página debe ser un número.',
            'per_page.min' => 'El número mínimo de elementos por página es :min.',
            'per_page.max' => 'El número máximo de elementos por página es :max.',
            'page.numeric' => 'El número de página debe ser un número.',
            'page.min' => 'El número de página debe ser al menos 1.',
        ];
    }
}

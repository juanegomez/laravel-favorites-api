<?php

namespace App\Http\Requests\Favorite;

use App\Http\Requests\BaseRequest;

class SaveFavoriteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all authenticated users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'api_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            // api_id
            'api_id.required' => 'El campo API ID es obligatorio.',
            'api_id.integer' => 'El campo API ID debe ser un número entero.',

            // name
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 255 caracteres.',

            // image
            'image.string' => 'El campo imagen debe ser una cadena de texto.',
            'image.max' => 'El campo imagen no debe exceder los 255 caracteres.',

            // description
            'description.string' => 'El campo descripción debe ser una cadena de texto.',
            'description.max' => 'El campo descripción no debe exceder los 255 caracteres.',
        ];
    }
}

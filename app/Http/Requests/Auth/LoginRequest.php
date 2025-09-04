<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
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
            'email' => 'required|string|email',
            'password' => 'required|min:8'
        ];
    }

    /**
     * Mensajes personalizados en español
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.string'   => 'El correo electrónico debe ser una cadena de texto válida.',
            'email.email'    => 'Debe ingresar un correo electrónico válido.',

            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min'      => 'La contraseña debe tener al menos :min caracteres.'
        ];
    }
}
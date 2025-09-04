<?php

namespace App\Http\Requests\user;

use App\Http\Requests\BaseRequest;

class StoreUserRequest extends BaseRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',                       // al menos una mayúscula
                'regex:/[!@#$%^&*(),.?":{}|<>]/',      // al menos un símbolo
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // ---- name ----
            'name.required' => 'El nombre es obligatorio.',
            'name.string'   => 'El nombre debe ser una cadena de texto.',
            'name.max'      => 'El nombre no puede tener más de 255 caracteres.',

            // ---- email ----
            'email.required' => 'El correo es obligatorio.',
            'email.string'   => 'El correo debe ser una cadena de texto.',
            'email.email'    => 'El correo debe tener un formato válido.',
            'email.max'      => 'El correo no puede tener más de 255 caracteres.',
            'email.unique'   => 'Este correo ya está registrado.',

            // ---- password ----
            'password.required' => 'La contraseña es obligatoria.',
            'password.string'   => 'La contraseña debe ser una cadena de texto.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex'    => 'La contraseña debe contener al menos una mayúscula y un símbolo (ej: !@#$%^&*).',
        ];
    }
}

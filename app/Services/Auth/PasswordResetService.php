<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class PasswordResetService
{
    /**
     * Envía el enlace de restablecimiento de contraseña al usuario.
     *
     * @param string $email
     * @return string
     */
    public function sendResetLink(string $email): string
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return 'No encontramos ningún usuario con ese correo electrónico.';
        }

        // Generar token
        $token = Str::random(60);
        
        // Guardar token en la tabla de usuarios
        $user->update([
            'password_reset_token' => Hash::make($token),
            'password_reset_at' => now()
        ]);

        // Enviar correo con el token
        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
        $resetLink = "{$frontendUrl}/reset-password/$token?email=" . urlencode($user->email);
        
        try {
            Mail::to($user->email)->send(new PasswordResetMail($resetLink, $user));
            return 'Hemos enviado un enlace de restablecimiento de contraseña a tu correo electrónico.';
        } catch (\Exception $e) {
            \Log::error('Error al enviar el correo de restablecimiento: ' . $e->getMessage());
            return 'No se pudo enviar el correo de restablecimiento. Por favor, inténtalo de nuevo más tarde.';
        }
    }

    /**
     * Restablece la contraseña del usuario.
     *
     * @param array $credentials
     * @return string
     */
    public function reset(array $credentials): string
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !$user->password_reset_token) {
            return 'No se pudo encontrar una solicitud de restablecimiento de contraseña para este correo electrónico.';
        }

        // Verificar si el token es válido
        if (!Hash::check($credentials['token'], $user->password_reset_token)) {
            return 'El token de restablecimiento de contraseña no es válido.';
        }

        // Verificar si el token ha expirado (15 minutos)
        if (Carbon::parse($user->password_reset_at)->addMinutes(15)->isPast()) {
            return 'El enlace de restablecimiento de contraseña ha expirado. Por favor, solicita uno nuevo.';
        }

        // Actualizar la contraseña y limpiar el token
        $user->update([
            'password' => Hash::make($credentials['password']),
            'password_reset_token' => null,
            'password_reset_at' => null
        ]);

        // Disparar evento de restablecimiento de contraseña
        event(new PasswordReset($user));

        return 'Tu contraseña ha sido restablecida correctamente.';
    }
}

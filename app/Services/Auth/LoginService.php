<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginService
{
    public function login(array $credentials): array
    {
        try {
            $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new \Exception('Credenciales inválidas', 401);
        }
        
        // Borrar tokens anteriores
        $user->tokens()->delete();

        // Generar token
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
        } catch (\Throwable $th) {
            Log::error('Error logging in: ' . $th->getMessage());
            throw new \Exception($th->getMessage(), $th->getCode());
        }
    }
}

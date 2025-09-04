<?php

namespace App\Http\Controllers;

use App\Http\Resources\user\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;

class AuthController extends Controller
{
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            $response = $this->loginService->login($credentials);
            
            return response()->json([
                'status' => 1,
                'message' => 'Login exitoso',
                'user' => new UserResource($response['user']),
                'access_token' => $response['access_token'],
                'token_type' => $response['token_type'],
            ])->setStatusCode(200);

        } catch (\Throwable $th) {
            Log::error('Error logging in: ' . $th->getMessage());
            $statusCode = $th->getCode() ?: 500;
            
            return response()->json([
                'message' => $th->getMessage() === 'Credenciales inválidas' 
                    ? $th->getMessage() 
                    : 'Error al iniciar sesión',
                'status' => 0,
                'error' => $th->getMessage()
            ])->setStatusCode($statusCode);
        }
    }

    public function logout(){
        try {
            auth()->user()->tokens()->delete();
    
            return response()->json([
                'status' => 1,
                'message' => 'Cierre de sesión exitoso'
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            Log::error('Error logging out: ' . $th->getMessage());
            return response()->json([
                'message' => 'Error al cerrar sesión',
                'status' => 0,
                'error' => $th->getMessage()
            ])->setStatusCode(500);
        }
    }
}

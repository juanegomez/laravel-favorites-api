<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\user\UserResource;
use App\Http\Requests\user\StoreUserRequest;

class UsersController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());

            return response()->json([
                    'status' => 1,
                    'message' => 'Usuario creado exitosamente',
                    'user' => new UserResource($user),
                ])
                ->setStatusCode(201);
        } catch (\Throwable $th) {
            Log::error('Error creating user: ' . $th->getMessage());
            return response()->json([
                'message' => 'Error al crear el usuario',
                'status' => 0,
                'error' => $th->getMessage()
            ])->setStatusCode(500);
        }
    }
}

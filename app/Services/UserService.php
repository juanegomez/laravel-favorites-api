<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function createUser(array $data): User
    {
        try {
            return User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        } catch (\Throwable $th) {
            Log::error('Error creating user: ' . $th->getMessage());
            throw $th;
        }
    }
}

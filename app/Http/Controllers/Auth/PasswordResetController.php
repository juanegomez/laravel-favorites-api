<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    protected PasswordResetService $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Envía un correo con el enlace para restablecer la contraseña.
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $status = $this->passwordResetService->sendResetLink($request->email);
        $isSuccess = $status === Password::RESET_LINK_SENT;
        
        return response()->json([
            'status' => $isSuccess ? 0 : 1,
            'message' => __($status)
        ], $isSuccess ? 400 : 200);
    }

    /**
     * Restablece la contraseña del usuario.
     *
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status = $this->passwordResetService->reset(
            $request->only('email', 'password', 'password_confirmation', 'token')
        );
        $isSuccess = $status === Password::PASSWORD_RESET;
        
        return response()->json([
            'status' => $isSuccess ? 0 : 1,
            'message' => __($status)
        ], $isSuccess ? 400 : 200);
    }
}

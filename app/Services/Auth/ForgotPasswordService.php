<?php

namespace App\Services\Auth;

use App\Traits\ApiResponse;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;

class ForgotPasswordService
{
    use ApiResponse;

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $validated = $request->validated();

            /**
             * For testing purposes, we are using the Password facade to send the reset link.
             * At the moment, we are storing the token in the laravel.log file
             * The token is stored in the following format:
             * [2025-10-22 10:00:00] local.INFO: Password reset token for test@example.com: [token]  
             * TODO: Implement the Mail facade to send the reset link.
             */

            /** @var \Illuminate\Http\Request $request */
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return $this->successResponse([], 'Reset link sent successfully.', 200);
            }

            return $this->successResponse(
                ['message' => 'If the email exists, a reset link has been sent.'],
                'Password reset requested',
                200
            );

        } catch (\Throwable $th) {
            return $this->errorResponse(
                $th->getMessage(),
                422,
                $th->getTraceAsString(),
                $th->getLine(),
                $th->getFile()
            );
        }
    }
}
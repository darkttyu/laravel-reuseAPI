<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\EmailToken;
use App\Traits\ApiResponse;
use App\Http\Requests\Auth\VerifyEmailRequest;

class VerifyEmailService
{
    use ApiResponse;

    public function verifyEmail(VerifyEmailRequest $request)
    {
        try {
            $validated = $request->validated();

            $emailToken = EmailToken::where('token', $validated['token'])->first();

            if(!$emailToken) {
                return $this->errorResponse('Invalid token.', 401);
            }

            $user = User::where('email', $emailToken->email)->first();

            if(!$user) {
                return $this->errorResponse('User not found.', 404);
            }

            if($user->email_verified_at) {
                return $this->errorResponse('Email already verified.', 400);
            }

            $user->email_verified_at = now();
            $user->save();

            $emailToken->delete();

            return $this->successResponse([
                'message' => 'Email verified successfully.'],
                'Email verification successful',
                200
            );

        } catch (\Throwable $th) {
            return $this->errorResponse(
                $th->getMessage(), 
                422, 
                $th->getTraceAsString(),
                $th->getLine(), 
                $th->getFile());
        }
    }
}

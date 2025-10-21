<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\PasswordResetToken;
use App\Traits\ApiResponse;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Str;

class ForgotPasswordService
{
    use ApiResponse;

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::query()->where('email', $validated['email'])->first();

            if (!$user) {
                return $this->errorResponse('User not found.', 404);
            }

            $token = Str::random(64);

            PasswordResetToken::create([
                'email' => $validated['email'],
                'token' => $token]);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 422, $th->getTraceAsString(), $th->getLine(), $th->getFile());
        }
    }
}
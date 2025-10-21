<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\PasswordResetToken;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;

class ResetPasswordService
{
    use ApiResponse;

    protected $salt;

    public function __construct() 
    {
        $this->salt = env('SALT');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $validated = $request->validated();

            $passwordResetTokens = PasswordResetToken::all();
            $passwordResetToken = null;

            foreach($passwordResetTokens as $token) {
                if (Hash::check($validated['token'], $token->token)) {
                    $passwordResetToken = $token;
                    $user = User::query()->where('email', $token->email)->first();
                    break;
                }
            }

            if (!$passwordResetToken || !$user) {
                return $this->errorResponse('Invalid token.', 401);
            }

            if (!Hash::check($validated['old_password'] . $this->salt, $user->password)) {
                return $this->errorResponse('Invalid old password.', 401);
            }

            $user->password = Hash::make($validated['new_password'] . $this->salt);
            $user->save();
            $user->tokens->each->delete();

            $passwordResetToken->delete();

            return $this->successResponse([], 'Password reset successful.', 200);
            
        } catch (\Throwable $th) {
            $this->errorResponse($th->getMessage(), 422, $th->getTraceAsString(), $th->getLine(), $th->getFile());
        }
    }
}
<?php

namespace App\Services\Auth;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponse;

class LoginService
{
    use ApiResponse;
    
    public function login(LoginRequest $request)
    {
        try {

            $validated = $request->validated();

            $user = User::query()->where('email', $validated['email'])->first();
            
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
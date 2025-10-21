<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\EmailToken;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    use ApiResponse;

    protected $salt;

    public function __construct() 
    {
        $this->salt = env('SALT');
    }
    
    public function login(LoginRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::query()->where('email', $validated['email'])->first();

            if(!$user) {
                return $this->errorResponse('User not Found.', 404);
            }

            if($user->email_verified_at == null) {
                return $this->errorResponse('Email not verified.', 401);
            }

            if(!Hash::check($validated['password'] . $this->salt, $user->password)) {
                return $this->errorResponse('Invalid credentials', 401);
            }

            Auth::login($user);
            $token = $user->createToken('user_token')->plainTextToken;

            $user->last_login_at = now();
            $user->save();

            return $this->successResponse([
                'token' => $token
            ], 'Login successful', 200);
            
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 422, $th->getTraceAsString(), $th->getLine(), $th->getFile());
        }

    }
}
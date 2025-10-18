<?php

namespace App\Services\Auth;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

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

            if (!$user) {
                return response->json([
                    'message' => 'User not Found.',
                    'error' => ['email' => ['Email does not exist.'] ]
                ], Response::HTTP_NOT_FOUND);
            }

            if(!Hash::check($validated->password . $this->salt, $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials',
                    'error' => ['password' => ['Wrong password.']]
                ], Response::HTTP_UNAUTHORIZED);
            }

            Auth::login($user);
            $token = $user->createToken('user_token')->plainTextToken;

            $user->last_login_at = now();
            $user->save();

            return response()->json([
                'message' => 'Login successful',
                'token' => $token
            ], Response::HTTP_OK);
            
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
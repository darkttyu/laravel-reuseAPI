<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\EmailToken;
use App\Traits\ApiResponse;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    use ApiResponse;

    protected $salt;

    public function __construct() 
    {
        $this->salt = env('SALT');
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::query()->where('email', $validated['email'])->first();

            $registeredUser = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'] . $this->salt)
            ]);

            $emailToken = EmailToken::create([
                'email' => $validated['email'],
                'token' => rand(100000, 999999)
            ]);

            /**
             * Make a mailer to send it to the user's email.
             */

            return $this->successResponse([
                'user' => $registeredUser->id,
                'email_token' => $emailToken->token,
                'message' => 'User created successfully.'
            ], 'User Creation Successful.', 200);

        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 422, $th->getTraceAsString(), $th->getLine(), $th->getFile());
        }
    }
}
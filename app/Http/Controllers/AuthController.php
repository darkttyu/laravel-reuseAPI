<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Services\Auth\LoginService;

class AuthController extends Controller
{
    protected LoginService $loginService;

    public function register(RegisterUserRequest $request)
    {

    }

    public function login(LoginRequest $request)
    {
        return $this->loginService->login($request);
    }

    public function logout()
    {

    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

    }

    public function resetPassword(ResetPasswordRequest $request)
    {

    }

    public function verifyEmail(VerifyEmailRequest $request)
    {

    }
}

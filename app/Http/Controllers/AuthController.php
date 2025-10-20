<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Services\Auth\LoginService;
use App\Services\Auth\RegisterService;
use App\Services\Auth\LogoutService;
use App\Services\Auth\VerifyEmailService;

class AuthController extends Controller
{
    protected $loginService;
    protected $registerService;
    protected $logoutService;
    protected $verifyEmailService;

    public function __construct(LoginService $loginService, RegisterService $registerService, LogoutService $logoutService, VerifyEmailService $verifyEmailService)
    {
        $this->loginService = $loginService;
        $this->registerService = $registerService;
        $this->logoutService = $logoutService;
        $this->verifyEmailService = $verifyEmailService;
    }

    public function register(RegisterUserRequest $request)
    {
        return $this->registerService->register($request);
    }

    public function login(LoginRequest $request)
    {
        return $this->loginService->login($request);
    }

    public function logout(Request $request)
    {
        return $this->logoutService->logout($request);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

    }

    public function resetPassword(ResetPasswordRequest $request)
    {

    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        return $this->verifyEmailService->verifyEmail($request);
    }
}

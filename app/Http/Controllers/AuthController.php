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
use App\Services\Auth\ForgotPasswordService;
use App\Services\Auth\ResetPasswordService;

class AuthController extends Controller
{
    protected $loginService;
    protected $registerService;
    protected $logoutService;
    protected $verifyEmailService;
    protected $forgotPasswordService;
    protected $resetPasswordService;

    public function __construct(LoginService $loginService, RegisterService $registerService, LogoutService $logoutService, VerifyEmailService $verifyEmailService, ForgotPasswordService $forgotPasswordService, ResetPasswordService $resetPasswordService)
    {
        $this->loginService = $loginService;
        $this->registerService = $registerService;
        $this->logoutService = $logoutService;
        $this->verifyEmailService = $verifyEmailService;
        $this->forgotPasswordService = $forgotPasswordService;
        $this->resetPasswordService = $resetPasswordService;
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
        return $this->forgotPasswordService->forgotPassword($request);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->resetPasswordService->resetPassword($request);
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        return $this->verifyEmailService->verifyEmail($request);
    }
}

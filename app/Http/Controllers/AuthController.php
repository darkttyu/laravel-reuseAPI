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


    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     description="Create a new user account and receive email verification token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", minLength=8, example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User Creation Successful."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="integer", example=1),
     *                 @OA\Property(property="email_token", type="integer", example=123456)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function register(RegisterUserRequest $request)
    {
        return $this->registerService->register($request);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     tags={"Authentication"},
     *     summary="Login user",
     *     description="Login with email and password to receive authentication token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="1|abcdefghijklmnopqrstuvwxyz")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Email not verified"
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        return $this->loginService->login($request);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     tags={"Authentication"},
     *     summary="Logout user",
     *     description="Revoke the current access token",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function logout(Request $request)
    {
        return $this->logoutService->logout($request);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/forgot-password",
     *     tags={"Authentication"},
     *     summary="Request password reset",
     *     description="Send password reset token to user's email",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reset link sent successfully"
     *     )
     * )
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        return $this->forgotPasswordService->forgotPassword($request);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/reset-password",
     *     tags={"Authentication"},
     *     summary="Reset password",
     *     description="Reset user password with token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"old_password","new_password","token"},
     *             @OA\Property(property="old_password", type="string", format="password", minLength=8, example="oldpassword123"),
     *             @OA\Property(property="new_password", type="string", format="password", minLength=8, example="newpassword123"),
     *             @OA\Property(property="token", type="string", example="reset_token_string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset successful"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid token or password"
     *     )
     * )
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->resetPasswordService->resetPassword($request);
    }
    
    /**
     * @OA\Post(
     *     path="/api/v1/auth/verify-email",
     *     tags={"Authentication"},
     *     summary="Verify email address",
     *     description="Verify user email with the token received during registration",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"token"},
     *             @OA\Property(property="token", type="integer", example=123456)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email verified successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Invalid token"
     *     )
     * )
     */
    public function verifyEmail(VerifyEmailRequest $request)
    {
        return $this->verifyEmailService->verifyEmail($request);
    }
}

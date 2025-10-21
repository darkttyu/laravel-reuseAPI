<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogoutService
{
    use ApiResponse;

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->successResponse([], 'Logout successful.', 200);
            
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 422, $th->getTraceAsString(), $th->getLine(), $th->getFile());
        }
    }
}
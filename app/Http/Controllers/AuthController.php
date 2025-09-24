<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());
        return $this->successResponse($result, 'User registered successfully', 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());
        if (!$result) return $this->errorResponse('Invalid credentials', 401);

        return $this->successResponse($result, 'Login successful');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse(null, 'Logged out successfully');
    }

    public function me(Request $request)
    {
        return $this->successResponse($request->user());
    }
}

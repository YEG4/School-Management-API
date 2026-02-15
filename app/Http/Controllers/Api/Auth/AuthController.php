<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function store(RegisterRequest $request)
    {
        $data = $this->authService->createUser($request->validated());

        return $this->success($data, 'User created successfully.', 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->authenticate($request->validated());

        return $this->success($data, 'User logged in successfully.');
    }

    public function logout(Request $request)
    {
        $this->authService->logUserOut($request->user());

        return $this->success(message: 'Successfully logged out.');
    }
}

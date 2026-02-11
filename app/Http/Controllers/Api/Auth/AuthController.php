<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);
        $token = $user->createToken('web')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(LoginRequest $request)
    {
        $user = $request->authenticate();

        $user->tokens()->delete();

        return response()->json([
            'token' => $user->createToken('main')->plainTextToken,
        ]);

    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->noContent();
    }
}

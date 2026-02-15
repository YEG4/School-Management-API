<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Eloquent\EloquentUserRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected EloquentUserRepository $users)
    {
        //
    }

    public function authenticate(array $credentials)
    {
        $user = $this->users->findByEmail($credentials['email']);

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw new HttpResponseException(response()->json([
                'message' => 'Invalid credentials.',
            ], 401));
        }

        return [
            'user' => $user->toResource(),
            'token' => $user->createToken('api_token')->plainTextToken,
        ];
    }

    public function createUser(array $data): array
    {
        $user = $this->users->create($data);
        $token = $user->createToken('api_token')->plainTextToken;

        return [
            'user' => $user->toResource(),
            'token' => $token,
        ];
    }

    public function logUserOut(User $user)
    {
        $user->currentAccessToken()->delete();
    }
}

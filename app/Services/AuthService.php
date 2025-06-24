<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    /**
     * Register a new user and return the user data along with a JWT token.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function register(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password'=> Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return ['user' => $user, 'token' => $token];
    }

    /**
     * Attempt to log in a user and return a JWT token if successful.
     *
     * @param array<string, mixed> $credentials
     * @return array<string, string>
     * 
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function login(array $credentials): array
    {
        if (! $token = JWTAuth::attempt($credentials)) {
            abort(401, 'Invalid credentials');
        }
        
        return ['token' => $token];
    }
}

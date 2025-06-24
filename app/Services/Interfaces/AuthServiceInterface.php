<?php

namespace App\Services\Interfaces;

interface AuthServiceInterface 
{
    /**
     * Handle user login with provided credentials.
     *
     * @param array<string, mixed> $data
     * @return mixed
     */
    public function login(array $data): mixed;

    /**
     * Handle user registration with provided data.
     *
     * @param array<string, mixed> $data
     * @return mixed
     */
    public function register(array $data): mixed;
}

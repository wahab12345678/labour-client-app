<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Authenticates a user based on the given credentials.
     *
     * @param array $credentials
     * @return array
     */
    public function authenticate(array $credentials)
    {
        $remember = $credentials['remember-me'] ?? false;
        $attempt = Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ]);

        if ($attempt) {
            return [
                'success' => true,
                'message' => 'Login successful.',
            ];
        }

        return [
            'success' => false,
            'message' => 'Invalid email or password.',
        ];
    }
}

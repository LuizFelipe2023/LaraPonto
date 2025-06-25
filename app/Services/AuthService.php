<?php

namespace App\Services;

use Exception;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function processLogin(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return Auth::user();
        }

        throw ValidationException::withMessages([
            'email' => 'As credenciais estão incorretas.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    public function getAuthenticatedUser()
    {
        return Auth::user();
    }

    public function updatePassword(array $validatedData)
    {
        $user = $this->getAuthenticatedUser();

        if (!Hash::check($validatedData['current_password'], (string) $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Senha atual incorreta.'],
            ]);
        }

        $user->password = Hash::make($validatedData['new_password']);
        $user->save();

        return true; 
    }
}

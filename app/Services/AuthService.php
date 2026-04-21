<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthService
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN MANUAL
    |--------------------------------------------------------------------------
    */

    public function login(array $credentials, bool $remember = false)
    {
        $user = User::where('email', $credentials['email'])->first();

        // akun google tidak boleh login password
        if ($user && is_null($user->password)) {
            throw new \Exception('Gunakan Login dengan Google.');
        }

        if (!Auth::attempt($credentials, $remember)) {
            throw new \Exception('Email atau password salah.');
        }

        request()->session()->regenerate();

        return Auth::user();
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return $user;
    }

    /*
    |--------------------------------------------------------------------------
    | GOOGLE LOGIN
    |--------------------------------------------------------------------------
    */

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
                'password' => null,
            ]);
        }

        Auth::login($user);

        return $user;
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}

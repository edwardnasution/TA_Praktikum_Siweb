<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Cek apakah user sudah ada, jika belum buat baru
        $user = User::firstOrNew(['email' => $googleUser->getEmail()]);
        $user->name = $googleUser->getName();
        $user->google_id = $googleUser->getId();
        $user->email_verified_at ??= now();

        if (! $user->exists) {
            $user->password = Str::random(32);
        }

        $user->save();

        Auth::login($user);
        return redirect()->route('home');
    }
}

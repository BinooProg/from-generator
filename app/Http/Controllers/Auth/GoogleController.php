<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Throwable;
use Laravel\Socialite\Two\InvalidStateException;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            try {
                $user = Socialite::driver('google')->user();
            } catch (InvalidStateException) {
                // In distributed/ephemeral environments, session state may be lost between redirect and callback.
                $user = Socialite::driver('google')->stateless()->user();
            }

            if (empty($user->email)) {
                return redirect('login')->with('error', 'Google account email is required to sign in.');
            }

            // Find or Create user
            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'name' => $user->name,
                    'google_id' => $user->id,
                    'password' => encrypt(random_bytes(16))
                ]);
                $newUser->markEmailAsVerified();
                event(new Verified($newUser));
                Auth::login($newUser);
            }

            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        } catch (Throwable $e) {
            Log::error('Google OAuth callback failed', [
                'message' => $e->getMessage(),
                'exception' => $e::class,
            ]);

            return redirect('login')->with('error', 'Google sign in failed. Please try again.');
        }
    }
}

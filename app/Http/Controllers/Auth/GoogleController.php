<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();

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
        } catch (Exception $e) {
            return redirect('login')->with('error', 'Something went wrong!');
        }
    }
}

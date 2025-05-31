<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            $findUser = User::where('google_id', $user->id)->first();
            
            if ($findUser) {
                Auth::login($findUser);
                return redirect()->intended('dashboard');
            } else {
                $findUserByEmail = User::where('email', $user->email)->first();
                
                if ($findUserByEmail) {
                    $findUserByEmail->update(['google_id' => $user->id]);
                    Auth::login($findUserByEmail);
                    return redirect()->intended('dashboard');
                } else {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id' => $user->id,
                        'password' => encrypt('123456dummy')
                    ]);
                    
                    Auth::login($newUser);
                    return redirect()->intended('dashboard');
                }
            }
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Login with Google failed. Please try again.');
        }
    }
}

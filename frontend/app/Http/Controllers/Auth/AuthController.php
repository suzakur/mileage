<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User; // Assuming you have a User model

class AuthController extends Controller
{
    // Login view
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                        ->withErrors($validator)
                        ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard')); // Or your intended redirect path
        }

        return redirect()->route('login')
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput();
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // Registration view (optional, if you need it)
    // public function showRegistrationForm()
    // {
    //     return view('auth.register');
    // }

    // Handle registration (optional)
    // public function register(Request $request)
    // {
    //     // Validator
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route('register')
    //                     ->withErrors($validator)
    //                     ->withInput();
    //     }

    //     // Create user
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password), // Hash password
    //     ]);

    //     // Log the user in
    //     Auth::login($user);

    //     return redirect()->route('dashboard'); // Or your intended redirect path
    // }
} 
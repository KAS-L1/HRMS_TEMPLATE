<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // API Login with Sanctum
    public function apiLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|min:8',
        ]);

        $credentials = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? ['email' => $request->login, 'password' => $request->password]
            : ['username' => $request->login, 'password' => $request->password];

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    // Web Login
    public function webLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|min:8',
        ]);

        $credentials = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? ['email' => $request->login, 'password' => $request->password]
            : ['username' => $request->login, 'password' => $request->password];

        if (!Auth::attempt($credentials, $request->filled('remember'))) {
            return back()->withErrors(['login' => 'Invalid credentials'])->withInput();
        }

        $request->session()->regenerate();
        return redirect()->intended('home')->with('success', 'Welcome back!');
    }

    // API Logout
    public function apiLogout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    // Web Logout
    public function webLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    // Registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'address' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'contact' => $request->contact,
            'status' => 'Active', // Default status
        ]);

        // Automatically log in the user after registration
        // Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful! Welcome to the application.');
    }

    // Forgot Password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Password reset link sent!')
            : back()->withErrors(['email' => 'Failed to send reset link.']);
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password reset successfully!')
            : back()->withErrors(['email' => 'Failed to reset password.']);
    }

    // Get authenticated user profile
    public function userProfile(Request $request)
    {
        return response()->json($request->user());
    }

    // Show Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Show Register Form
    public function showRegisterForm()
    {
        return view('auth.register'); // Ensure this view exists in resources/views/auth/register.blade.php
    }

    // Show Forgot Password Form
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Show Reset Password Form
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => request('email')]);
    }
}

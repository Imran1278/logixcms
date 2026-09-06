<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StudentLoginController extends Controller
{
    /**
     * Show the student login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.student-login');
    }

    /**
     * Handle an incoming student authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::where('email', $request->email)->first();

        // 1. Check if user exists
        if (!$user) {
            return back()->withErrors([
                'email' => 'This email address is not registered. Please contact administration.',
            ])->onlyInput('email');
        }

        // 2. Check if user possesses the student role
        if ($user->role !== 'student') {
            return back()->withErrors([
                'email' => 'Access denied. Only student accounts can log in here.',
            ])->onlyInput('email');
        }

        // 3. First-Time Setup Logic: If profile is not completed/password not chosen by student yet
        if (!$user->profile_completed) {
            $user->password = Hash::make($request->password);
            $user->profile_completed = true;
            $user->save();

            Auth::guard('web')->login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->route('student.dashboard')
                ->with('success', 'Your password has been set successfully! Welcome to your dashboard.');
        }

        // 4. Standard Authentication Attempt
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('student.dashboard'))
                ->with('success', 'Welcome back! Logged in successfully.');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password credentials.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated student session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login')
            ->with('info', 'You have been logged out successfully.');
    }
}
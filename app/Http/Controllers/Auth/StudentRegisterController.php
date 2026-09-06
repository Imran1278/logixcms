<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class StudentRegisterController extends Controller
{
    /**
     * Show the student registration form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.student-register');
    }

    /**
     * Handle student registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name'                 => trim($request->name),
            'email'                => strtolower(trim($request->email)),
            'password'             => Hash::make($request->password),
            'role'                 => 'student',
            'is_profile_complete' => false,
        ]);

        return redirect()->route('student.login')
            ->with('success', 'Registration successful! Please log in with your credentials.');
    }
}
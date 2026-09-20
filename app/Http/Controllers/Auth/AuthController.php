<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (! auth()->user()->isAdmin()) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Unauthorized access.',
                ]);
            }

            $name = auth()->user()->name;
            auth()->user()->update(['last_login_at' => now()]);

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('toast', ['type' => 'success', 'message' => "Welcome back, {$name}!"]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('toast', ['type' => 'success', 'message' => 'You have been logged out successfully.']);
    }

    public function showForgotPassword()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'We could not find an account with that email address.',
        ]);

        $request->session()->put('reset_email', $request->input('email'));

        return redirect()
            ->route('admin.reset-password')
            ->with('status', 'Email verified! Set your new password below.');
    }

    public function showResetPassword()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        if (! session()->has('reset_email')) {
            return redirect()->route('admin.forgot-password');
        }

        return view('admin.auth.reset-password', ['email' => session('reset_email')]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.exists' => 'We could not find an account with that email address.',
        ]);

        $user = User::where('email', $validated['email'])->firstOrFail();
        $user->update(['password' => $validated['password']]);

        session()->forget('reset_email');

        return redirect()
            ->route('admin.login')
            ->with('toast', ['type' => 'success', 'message' => 'Password reset successfully. Please log in.']);
    }
}

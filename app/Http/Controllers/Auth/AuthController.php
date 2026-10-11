<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::ResetLinkSent) {
            return back()->with('toast', ['type' => 'success', 'message' => 'We have emailed your password reset link! Please check your inbox.']);
        }

        return back()->withErrors([
            'email' => 'We are unable to send a reset link right now. Please try again in a moment.',
        ])->onlyInput('email');
    }

    public function showResetPassword(Request $request, string $token)
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.exists' => 'We could not find an account with that email address.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => $password,
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PasswordReset) {
            return redirect()
                ->route('admin.login')
                ->with('toast', ['type' => 'success', 'message' => 'Password reset successfully. Please log in with your new password.']);
        }

        return back()
            ->withErrors(['email' => 'This password reset link is invalid or has expired. Please request a new one.'])
            ->onlyInput('email');
    }
}

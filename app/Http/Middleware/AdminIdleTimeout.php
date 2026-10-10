<?php

namespace App\Http\Middleware;

use App\Services\SettingsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminIdleTimeout
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            $minutes = max(1, (int) SettingsService::get('auto_logout_minutes', '15'));
            $sessionKey = 'admin_last_active';
            $lastActive = (int) $request->session()->get($sessionKey, now()->timestamp);

            if (now()->timestamp - $lastActive > $minutes * 60) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('admin.login')
                    ->with('toast', ['type' => 'info', 'message' => 'You were signed out due to inactivity. Please sign in again.']);
            }

            $request->session()->put($sessionKey, now()->timestamp);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use App\Services\SettingsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigureAdminSessionLifetime
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin') || $request->is('admin/*')) {
            $minutes = (int) SettingsService::get('auto_logout_minutes', '15');

            if ($minutes < 1) {
                $minutes = 15;
            }

            config(['session.lifetime' => $minutes]);
        }

        return $next($request);
    }
}
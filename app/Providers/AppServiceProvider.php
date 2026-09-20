<?php

namespace App\Providers;

use App\Models\User;
use App\Services\SettingsService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['frontend.*', 'components.frontend.*', 'errors.*'], function ($view) {
            $admin = User::where('is_admin', true)->first();

            $view->with([
                'profile' => $admin?->profile,
                'settings' => SettingsService::all(),
            ]);
        });
    }
}

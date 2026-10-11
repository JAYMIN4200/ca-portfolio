<?php

namespace App\Providers;

use App\Models\User;
use App\Services\SettingsService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
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
        ResetPassword::createUrlUsing(function (User $notifiable, string $token): string {
            return route('admin.reset-password', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);
        });

        ResetPassword::toMailUsing(function (User $notifiable, string $token): MailMessage {
            $url = route('admin.reset-password', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);

            $expireMinutes = (int) config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

            return (new MailMessage)
                ->subject('Reset Your Password')
                ->view('emails.auth.reset-password', [
                    'url' => $url,
                    'userName' => $notifiable->name,
                    'expireMinutes' => $expireMinutes,
                ])
                ->text('emails.auth.reset-password-text', [
                    'url' => $url,
                    'userName' => $notifiable->name,
                    'expireMinutes' => $expireMinutes,
                ]);
        });

        View::composer(['frontend.*', 'components.frontend.*', 'errors.*'], function ($view) {
            $admin = User::where('is_admin', true)->first();

            $view->with([
                'profile' => $admin?->profile,
                'settings' => SettingsService::all(),
            ]);
        });
    }
}

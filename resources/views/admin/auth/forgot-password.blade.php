@php
    $siteName = \App\Services\SettingsService::get('site_name', config('app.name'));
@endphp

<x-admin.layouts.guest :title="'Forgot Password'">
    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex justify-center">
                    <x-admin.brand-mark size="h-16 w-16" text="text-2xl" rounded="rounded-2xl" />
                </div>
                <h1 class="text-2xl font-semibold text-white">Forgot Password</h1>
                <p class="mt-1 text-sm text-slate-400">Enter your admin email to reset your password</p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-xl sm:p-8">
                <form method="POST" action="{{ route('admin.forgot-password.submit') }}">
                    @csrf

                    <div class="space-y-5">
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                                placeholder="you@example.com"
                                class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-navy-800 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:ring-offset-2">
                            Verify Email
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-6 text-center text-xs text-slate-500">
                <a href="{{ route('admin.login') }}" class="hover:text-slate-300">← Back to login</a>
            </p>
        </div>
    </div>
</x-admin.layouts.guest>
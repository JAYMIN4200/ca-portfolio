<x-admin.layouts.guest :title="'Admin Login'">
    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex justify-center">
                    <x-admin.brand-mark size="h-16 w-16" text="text-2xl" rounded="rounded-2xl" />
                </div>
                <h1 class="text-2xl font-semibold text-white">Admin Panel</h1>
                <p class="mt-1 text-sm text-slate-400">{{ \App\Services\SettingsService::get('site_name', config('app.name')) }}</p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-xl sm:p-8">
                <form method="POST" action="{{ route('admin.login') }}">
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

                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required autocomplete="current-password"
                                    placeholder="Enter your password"
                                    class="block w-full rounded-lg border border-slate-300 px-3 py-2 pr-10 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-navy-500 focus:ring-navy-500">
                                <button type="button" data-password-toggle="password" aria-label="Show password"
                                    class="absolute inset-y-0 right-0 flex w-10 items-center justify-center text-slate-400 transition-colors hover:text-navy-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" data-eye-open>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hidden h-5 w-5" data-eye-closed>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 text-sm text-slate-600">
                                <input type="checkbox" name="remember" class="rounded border-slate-300 text-navy-600 focus:ring-navy-500">
                                Remember me
                            </label>
                            <a href="{{ route('admin.forgot-password') }}" class="text-sm font-medium text-navy-700 hover:text-navy-900 hover:underline">Forgot password?</a>
                        </div>

                        <button type="submit"
                            class="w-full rounded-lg bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-navy-800 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:ring-offset-2">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-6 text-center text-xs text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-slate-300">← Back to website</a>
            </p>
        </div>
    </div>
</x-admin.layouts.guest>
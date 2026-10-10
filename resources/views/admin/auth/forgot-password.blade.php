<x-admin.layouts.guest :title="'Forgot Password'">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        <x-admin.auth-card heading="Reset your password" subtitle="Enter your admin email and we'll email you a reset link.">
            <form method="POST" action="{{ route('admin.forgot-password.submit') }}">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-slate-300">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                            placeholder="you@example.com"
                            class="block w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-gold-400 focus:ring-gold-400/30">
                        @error('email')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-gradient-to-r from-gold-400 to-gold-600 px-4 py-2.5 text-sm font-semibold text-navy-950 shadow-md shadow-gold-500/25 transition hover:from-gold-500 hover:to-gold-700 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:ring-offset-2 focus:ring-offset-night">
                        Send Reset Link
                    </button>
                </div>
            </form>
        </x-admin.auth-card>

        <p class="mt-6 text-center text-xs text-slate-500">
            <a href="{{ route('admin.login') }}" class="transition-colors hover:text-slate-300">&larr; Back to login</a>
        </p>
    </div>
</x-admin.layouts.guest>
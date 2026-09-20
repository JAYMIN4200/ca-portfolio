<x-frontend.layouts.app :seoTitle="'429 | Too Many Requests'">
    <section class="relative overflow-hidden bg-night">
        <div class="absolute inset-0 aurora-bg"></div>
        <div class="absolute inset-0 gst-grid"></div>
        <span aria-hidden="true" class="pointer-events-none absolute left-[10%] top-24 select-none font-display text-6xl font-extrabold text-white/5 animate-float">₹</span>
        <span aria-hidden="true" class="pointer-events-none absolute right-[12%] bottom-24 select-none font-display text-7xl font-extrabold text-violet-500/10 animate-float-slow">%</span>
        <div class="absolute -top-40 -right-40 h-96 w-96 rounded-full bg-violet-600/20 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-navy-500/20 blur-3xl"></div>

        <div class="container-app relative flex min-h-screen flex-col items-center justify-center py-32 text-center">
            <p class="font-display text-8xl font-bold md:text-9xl">
                <span class="bg-gradient-to-r from-violet-300 via-violet-400 to-violet-200 bg-clip-text text-transparent">429</span>
            </p>
            <h1 class="mt-4 text-2xl font-semibold text-white md:text-3xl">Too Many Requests</h1>
            <p class="mx-auto mt-3 max-w-md text-sm text-slate-400">
                You have sent too many requests in a short period. Please wait a moment and try again.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('home') }}" class="rounded-lg bg-gradient-to-r from-violet-500 to-violet-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-violet-700/30 transition-all hover:-translate-y-0.5 hover:from-violet-400 hover:to-violet-600">Back to Home</a>
                <a href="{{ route('contact') }}" class="rounded-lg border border-white/20 bg-night/5 px-6 py-3 text-sm font-semibold text-white backdrop-blur transition-all hover:bg-night/10">Contact Me</a>
            </div>
        </div>
    </section>
</x-frontend.layouts.app>
<x-frontend.layouts.app :seoTitle="'Resume | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Resume"
        title="My Professional Resume"
        description="Download my latest professional resume."
    />

    <section class="bg-ink py-16 md:py-20">
        <div class="container-app">
            <div class="mx-auto max-w-2xl overflow-hidden rounded-2xl border border-white/10 bg-night/5 shadow-lg">
                <div class="flex flex-col items-start justify-between gap-4 border-b border-white/10 bg-gradient-to-r from-navy-900 to-navy-800 px-6 py-5 sm:flex-row sm:items-center">
                    <div class="flex items-center gap-3 keep-white text-white">
                        <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-500/90">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">{{ basename($profile->resume_path) }}</p>
                            <p class="text-xs text-slate-300">Professional Resume · PDF</p>
                        </div>
                    </div>
                    <a href="{{ route('resume.download') }}" class="inline-flex items-center gap-2 rounded-lg bg-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-violet-500/20 transition-colors hover:bg-violet-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download Resume
                    </a>
                </div>

                <div class="px-6 py-10 text-center">
                    <p class="text-sm leading-relaxed text-slate-300">
                        My resume is available for download as a PDF. Click the button above to save a copy.
                    </p>
                    @if (!empty($settings['contact_email']))
                        <p class="mt-2 text-xs text-slate-400">
                            For any queries, write to
                            <a href="mailto:{{ $settings['contact_email'] }}" class="font-medium text-violet-400 hover:underline">{{ $settings['contact_email'] }}</a>.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-frontend.layouts.app>

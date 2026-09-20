<x-frontend.layouts.app :seoTitle="'Contact | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Contact"
        title="Get in Touch"
        description="Have a professional requirement or opportunity? I'd love to hear from you."
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app grid grid-cols-1 gap-12 lg:grid-cols-2">
            <div data-reveal="left">
                <h2 class="text-2xl font-semibold text-white">Send Me a Message</h2>
                <p class="mt-2 text-sm text-slate-300">
                    Fill out the form and I'll get back to you as soon as possible.
                </p>

                @if (session('status'))
                    <div class="mt-6 flex items-start gap-3 rounded-xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-200" data-reveal="zoom">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="mt-6 space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-slate-300">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Enter your full name"
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('name') ? 'border-red-400' : '' }}">
                            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-slate-300">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="you@example.com"
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('email') ? 'border-red-400' : '' }}">
                            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="mb-1.5 block text-sm font-medium text-slate-300">Phone <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="+91 98765 43210"
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('phone') ? 'border-red-400' : '' }}">
                            @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="subject" class="mb-1.5 block text-sm font-medium text-slate-300">Subject <span class="text-red-500">*</span></label>
                            <select name="subject" id="subject" required data-custom-select
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('subject') ? 'border-red-400' : '' }}">
                                <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select a subject</option>
                                @foreach (['Accounting & Bookkeeping', 'Audit & Assurance', 'GST Compliance', 'Income Tax & ITR', 'TDS & Payroll', 'Career / Articleship', 'Other'] as $option)
                                    <option value="{{ $option }}" {{ old('subject') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @error('subject')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div data-subject-other class="{{ old('subject') === 'Other' ? '' : 'hidden' }}">
                        <label for="subject_other" class="mb-1.5 block text-sm font-medium text-slate-300">Please specify <span class="text-red-500">*</span></label>
                        <input type="text" name="subject_other" id="subject_other" value="{{ old('subject_other') }}" placeholder="Enter your subject"
                            class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('subject_other') ? 'border-red-400' : '' }}">
                        @error('subject_other')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="message" class="mb-1.5 block text-sm font-medium text-slate-300">Message <span class="text-red-500">*</span></label>
                        <textarea name="message" id="message" rows="6" required
                            class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('message') ? 'border-red-400' : '' }}"
                            placeholder="Tell me about your requirement...">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-violet-500 to-violet-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-violet-700/30 transition-all hover:from-violet-400 hover:to-violet-600 hover:shadow-violet-500/40 sm:w-auto">
                        Send Message
                    </button>
                </form>
            </div>

            <aside class="space-y-6" data-reveal="right">
                <div class="rounded-2xl border border-white/10 bg-night/5 p-6">
                    <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider text-slate-400">Contact Information</h3>
                    <ul class="space-y-5">
                        @if (!empty($settings['contact_email']))
                            <li class="flex items-start gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-slate-300">Email</p>
                                    <a href="mailto:{{ $settings['contact_email'] }}" class="break-all text-sm text-slate-300 hover:text-violet-300">{{ $settings['contact_email'] }}</a>
                                </div>
                            </li>
                        @endif
                        @if (!empty($settings['contact_phone']))
                            <li class="flex items-start gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-slate-300">Phone</p>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['contact_phone']) }}" class="text-sm text-slate-300 hover:text-violet-300">{{ $settings['contact_phone'] }}</a>
                                </div>
                            </li>
                        @endif
                        @if (!empty($settings['contact_location']))
                            <li class="flex items-start gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-slate-300">Location</p>
                                    <p class="text-sm text-slate-300">{{ $settings['contact_location'] }}</p>
                                </div>
                            </li>
                        @endif
                    </ul>

                    @php $handles = $profile?->socialHandles() ?? []; @endphp
                    @if (!empty($handles))
                        <div class="mt-5 border-t border-white/10 pt-5">
                            <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Find Me Online</p>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach ($handles as $key => $href)
                                    <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" aria-label="{{ ucfirst($key) }}"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30 transition-all hover:scale-110 hover:bg-violet-600 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                            <path d="@php
                                                $icons = [
                                                    'instagram' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z',
                                                    'facebook' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
                                                    'twitter' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z',
                                                    'telegram' => 'M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z',
                                                    'linkedin' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z',
                                                    'github' => 'M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12',
                                                    'whatsapp' => 'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z',
                                                ];
                                                echo $icons[$key] ?? '';
                                            @endphp" />
                                        </svg>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="rounded-2xl border border-violet-500/20 bg-gradient-to-br from-navy-900 to-violet-950 p-6 text-white">
                    <h3 class="text-lg font-semibold">Available for Opportunities</h3>
                    <p class="mt-2 text-sm text-slate-300">
                        I'm currently pursuing my CA Final alongside my Articleship and am open to professional discussions,
                        collaboration opportunities, and relevant engagements in accounting, audit and taxation.
                    </p>
                    @if (!empty($profile?->resume_path))
                        <a href="{{ route('resume.download') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-violet-600 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-violet-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Download Resume
                        </a>
                    @endif
                </div>
            </aside>
        </div>
    </section>

    <section class="bg-ink py-16 md:py-20">
        <div class="container-app">
            <div class="mx-auto max-w-2xl text-center" data-reveal="fade">
                <p class="text-sm font-semibold uppercase tracking-widest text-violet-600">Book a Meeting</p>
                <h2 class="mt-3 text-2xl font-semibold text-white md:text-3xl">Schedule a Consultation</h2>
                <p class="mt-4 text-base text-slate-300">Pick a date and time that works for you and we'll confirm the meeting shortly.</p>
            </div>

            <div class="mx-auto mt-10 max-w-3xl rounded-2xl border border-white/10 bg-night/5 p-6 shadow-lg backdrop-blur md:p-8" data-reveal="zoom">
                <form method="POST" action="{{ route('meetings.store') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="meeting_name" class="mb-1.5 block text-sm font-medium text-slate-300">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="meeting_name" value="{{ old('name') }}" required placeholder="Your full name"
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('name') ? 'border-red-400' : '' }}">
                            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="meeting_email" class="mb-1.5 block text-sm font-medium text-slate-300">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="meeting_email" value="{{ old('email') }}" required placeholder="you@example.com"
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('email') ? 'border-red-400' : '' }}">
                            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="meeting_phone" class="mb-1.5 block text-sm font-medium text-slate-300">Phone</label>
                            <input type="tel" name="phone" id="meeting_phone" value="{{ old('phone') }}" maxlength="15" inputmode="tel" placeholder="+91 98765 43210"
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('phone') ? 'border-red-400' : '' }}">
                            @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="meeting_title" class="mb-1.5 block text-sm font-medium text-slate-300">Meeting Subject <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="meeting_title" value="{{ old('title') }}" required placeholder="E.g. Tax filing consultation"
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('title') ? 'border-red-400' : '' }}">
                            @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div>
                            <label for="meeting_date" class="mb-1.5 block text-sm font-medium text-slate-300">Preferred Date <span class="text-red-500">*</span></label>
                            <input type="date" name="meeting_date" id="meeting_date" value="{{ old('meeting_date') }}" min="{{ now()->toDateString() }}" data-custom-picker="date" required
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('meeting_date') ? 'border-red-400' : '' }}">
                            @error('meeting_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="meeting_time" class="mb-1.5 block text-sm font-medium text-slate-300">Preferred Time</label>
                            <input type="time" name="start_time" id="meeting_time" value="{{ old('start_time') }}" data-custom-picker="time"
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('start_time') ? 'border-red-400' : '' }}">
                            @error('start_time')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="meeting_type" class="mb-1.5 block text-sm font-medium text-slate-300">Meeting Type <span class="text-red-500">*</span></label>
                            <select name="type" id="meeting_type" required data-custom-select
                                class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('type') ? 'border-red-400' : '' }}">
                                @foreach (\App\Models\Meeting::TYPES as $value => $label)
                                    <option value="{{ $value }}" {{ old('type') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="meeting_notes" class="mb-1.5 block text-sm font-medium text-slate-300">Notes</label>
                        <textarea name="notes" id="meeting_notes" rows="4" placeholder="Anything you'd like to discuss?"
                            class="block w-full rounded-lg border border-white/15 bg-white/5 px-3.5 py-2.5 text-sm text-white shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:ring-violet-500/40 {{ $errors->has('notes') ? 'border-red-400' : '' }}">{{ old('notes') }}</textarea>
                        @error('notes')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-violet-500 to-violet-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-violet-700/30 transition-all hover:from-violet-400 hover:to-violet-600 hover:shadow-violet-500/40 sm:w-auto">
                        Request Meeting
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-frontend.layouts.app>
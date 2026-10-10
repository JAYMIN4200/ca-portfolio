{{-- Full-page decorative layer for the auth screens. Reuses the front
     site's signature treatment (big faint CA watermarks + GST dot-grid +
     soft glows) but with the full icon set — ₹, GST, %, TAX and an
     invoice — so the admin login feels like the practice, not just one
     symbol. Rendered behind the single glass card; pointer-events are
     off so it never blocks the form. --}}
<div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
    <div class="gst-grid absolute inset-0"></div>

    <div class="absolute -left-24 top-1/4 h-80 w-80 rounded-full bg-violet-600/20 blur-3xl"></div>
    <div class="absolute -right-24 top-1/3 h-80 w-80 rounded-full bg-navy-500/20 blur-3xl"></div>
    <div class="absolute bottom-0 left-1/4 h-72 w-72 rounded-full bg-gold-500/10 blur-3xl"></div>

    {{-- Big ₹ --}}
    <span aria-hidden="true" class="pointer-events-none absolute -right-6 -top-12 select-none font-display text-[14rem] font-extrabold leading-none text-violet-500/10 animate-float-slow sm:text-[18rem]">₹</span>

    {{-- Big GST --}}
    <span aria-hidden="true" class="pointer-events-none absolute left-[4%] top-[20%] select-none font-display text-[9rem] font-extrabold tracking-tight text-white/5 animate-float sm:text-[12rem]">GST</span>

    {{-- Big % --}}
    <span aria-hidden="true" class="pointer-events-none absolute bottom-[8%] right-[10%] select-none font-display text-[8rem] font-extrabold text-violet-500/10 animate-float-slow sm:text-[11rem]">%</span>

    {{-- Big TAX --}}
    <span aria-hidden="true" class="pointer-events-none absolute bottom-[14%] left-[16%] select-none font-display text-[7rem] font-extrabold tracking-tight text-gold-400/10 animate-float">TAX</span>

    {{-- Invoice watermark --}}
    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor"
        class="absolute right-[6%] top-[42%] h-40 w-40 select-none text-gold-400/10 animate-float-slow sm:h-52 sm:w-52">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 2.5h12v19l-3-2-3 2-3-2-3 2z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 7.5h5M9.5 11h5M9.5 14.5h3" />
    </svg>

    {{-- Smaller accents --}}
    <span aria-hidden="true" class="pointer-events-none absolute left-[12%] top-[52%] select-none font-display text-6xl font-extrabold text-white/5 animate-float-slow">₹</span>
    <span aria-hidden="true" class="pointer-events-none absolute right-[26%] bottom-[36%] select-none font-display text-5xl font-extrabold text-white/5 animate-float">₹</span>
</div>
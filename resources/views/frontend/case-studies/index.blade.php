<x-frontend.layouts.app :seoTitle="'Case Studies | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Our Work"
        title="Case Studies"
        description="Real engagements, real outcomes — a closer look at how we help clients achieve their goals."
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app" data-ajax-list="results">
            <div id="results">
                @include('frontend.case-studies._list')
            </div>
        </div>
    </section>
</x-frontend.layouts.app>

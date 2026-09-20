<x-frontend.layouts.app :seoTitle="'Blog | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Insights"
        title="From the Blog"
        description="Practical notes on taxation, compliance, audit and business advisory."
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app" data-ajax-list="results">
            <div id="results">
                @include('frontend.blog._list')
            </div>
        </div>
    </section>
</x-frontend.layouts.app>

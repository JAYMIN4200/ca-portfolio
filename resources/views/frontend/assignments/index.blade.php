<x-frontend.layouts.app :seoTitle="'Professional Assignments | ' . ($settings['site_name'] ?? 'Jinendra Panchal')">
    <x-frontend.page-header
        eyebrow="Portfolio"
        title="Professional Assignments"
        description="A selection of practical assignments and professional work undertaken — presented without revealing confidential client information."
    />

    <section class="bg-night py-16 md:py-20">
        <div class="container-app" data-ajax-list="results">
            <div id="results">
                @include('frontend.assignments._list')
            </div>
        </div>
    </section>
</x-frontend.layouts.app>

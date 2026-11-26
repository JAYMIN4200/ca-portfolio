<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendPagesRenderTest extends TestCase
{
    use RefreshDatabase;

    public function test_frontend_pages_render_and_have_balanced_markup(): void
    {
        $this->seed();

        $uris = [
            '/', '/about', '/services', '/skills', '/assignments',
            '/blog', '/case-studies', '/testimonials', '/experience',
            '/contact', '/qualifications',
        ];

        if ($blog = BlogPost::query()->first()) {
            $uris[] = route('blog.show', $blog, false);
        }
        if ($caseStudy = CaseStudy::query()->first()) {
            $uris[] = route('case-studies.show', $caseStudy, false);
        }
        if ($assignment = Assignment::query()->first()) {
            $uris[] = route('assignments.show', $assignment, false);
        }

        foreach ($uris as $uri) {
            $response = $this->get($uri);

            $this->assertSame(200, $response->getStatusCode(), "Failed to load: {$uri}");

            $content = $response->getContent();
            $this->assertStringNotContainsString('x-frontend.grid', $content, "Unclosed grid component on {$uri}");
            $this->assertSame(
                substr_count($content, '<div'),
                substr_count($content, '</div>'),
                "Unbalanced <div> tags on {$uri}"
            );
        }
    }

    public function test_financial_advisory_skill_is_seeded_and_visible(): void
    {
        $this->seed();

        $this->get(route('skills'))
            ->assertSee('Financial Advisory')
            ->assertSee('Financial Planning & Analysis');
    }

    public function test_contact_page_partnership_copy_uses_the_configured_site_title(): void
    {
        SettingsService::set('site_title', 'Dynamic Test Firm');

        $this->get(route('contact'))
            ->assertSee('Building Professional Partnerships')
            ->assertSee('At Dynamic Test Firm, we value meaningful professional relationships')
            ->assertDontSee('Available for Opportunities')
            ->assertDontSee("I'm a Chartered Accountant and am open to professional discussions");
    }
}

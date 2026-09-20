<?php

namespace Tests\Feature;

use App\Models\CaseStudy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaseStudyModuleTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_frontend_index_only_lists_active_published_studies(): void
    {
        CaseStudy::factory()->create(['title' => 'Visible Engagement']);
        CaseStudy::factory()->inactive()->create(['title' => 'Hidden Engagement']);
        CaseStudy::factory()->create([
            'title' => 'Future Engagement',
            'published_at' => now()->addMonth()->toDateString(),
        ]);

        $this->get('/case-studies')
            ->assertOk()
            ->assertSee('Visible Engagement')
            ->assertDontSee('Hidden Engagement')
            ->assertDontSee('Future Engagement');
    }

    public function test_inactive_case_study_returns_not_found(): void
    {
        $caseStudy = CaseStudy::factory()->inactive()->create();

        $this->get("/case-studies/{$caseStudy->slug}")->assertNotFound();
    }

    public function test_published_case_study_is_viewable(): void
    {
        $caseStudy = CaseStudy::factory()->create();

        $this->get("/case-studies/{$caseStudy->slug}")
            ->assertOk()
            ->assertSee($caseStudy->title);
    }

    public function test_admin_can_create_a_case_study(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/case-studies', [
                'title' => 'New Audit Engagement',
                'client_name' => 'Acme Pvt Ltd',
                'category' => 'Audit',
                'summary' => 'A short summary.',
                'is_active' => 1,
            ])
            ->assertRedirect('/admin/case-studies')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('case_studies', [
            'title' => 'New Audit Engagement',
            'slug' => 'new-audit-engagement',
        ]);
    }

    public function test_case_study_title_is_required(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/case-studies', ['title' => ''])
            ->assertSessionHasErrors('title');
    }

    public function test_case_study_create_and_edit_pages_render(): void
    {
        $caseStudy = CaseStudy::factory()->create();

        $this->actingAs($this->admin())
            ->get('/admin/case-studies/create')
            ->assertOk();

        $this->actingAs($this->admin())
            ->get("/admin/case-studies/{$caseStudy->slug}/edit")
            ->assertOk();
    }
}

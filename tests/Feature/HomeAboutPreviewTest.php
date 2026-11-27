<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeAboutPreviewTest extends TestCase
{
    use RefreshDatabase;

    private function adminWithAbout(string $aboutMe): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        Profile::create([
            'user_id' => $admin->id,
            'about_me' => $aboutMe,
        ]);
    }

    public function test_home_renders_all_plain_text_paragraphs_in_an_expandable_preview(): void
    {
        $this->adminWithAbout("First paragraph.\n\nSecond paragraph.\n\nFinal paragraph that was previously hidden.");

        $this->get('/')
            ->assertOk()
            ->assertSee('data-about-expand', false)
            ->assertSee('aria-expanded="false"', false)
            ->assertSee('home-about-preview', false)
            ->assertSee('max-h-44 overflow-hidden', false)
            ->assertSee('Final paragraph that was previously hidden.', false);
    }

    public function test_home_renders_all_rich_text_content_in_an_expandable_preview(): void
    {
        $this->adminWithAbout('<p>First rich paragraph.</p><p>Final rich paragraph that was previously hidden.</p>');

        $this->get('/')
            ->assertOk()
            ->assertSee('data-about-expand', false)
            ->assertSee('Final rich paragraph that was previously hidden.', false);
    }

    public function test_home_renders_the_name_as_staggered_letters_with_an_accessible_label(): void
    {
        $this->get('/')
            ->assertSee('aria-label="Jinendra Panchal"', false)
            ->assertSee('style="--letter-index: 0"', false)
            ->assertSee('style="--letter-index: 15"', false)
            ->assertSee('</span><span class="hero-name-letter"', false);
    }
}

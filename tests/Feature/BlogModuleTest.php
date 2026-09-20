<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogModuleTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_frontend_index_only_lists_published_posts(): void
    {
        BlogPost::factory()->create(['title' => 'Published Article']);
        BlogPost::factory()->draft()->create(['title' => 'Draft Article']);

        $this->get('/blog')
            ->assertOk()
            ->assertSee('Published Article')
            ->assertDontSee('Draft Article');
    }

    public function test_draft_post_returns_not_found(): void
    {
        $post = BlogPost::factory()->draft()->create();

        $this->get("/blog/{$post->slug}")->assertNotFound();
    }

    public function test_viewing_a_post_increments_views(): void
    {
        $post = BlogPost::factory()->create(['views' => 0]);

        $this->get("/blog/{$post->slug}")->assertOk();

        $this->assertSame(1, $post->fresh()->views);
    }

    public function test_admin_can_create_a_blog_post_with_parsed_tags(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/blog-posts', [
                'title' => 'GST Filing Basics',
                'excerpt' => 'A quick primer.',
                'content' => 'Full content here.',
                'category' => 'Taxation',
                'tags' => 'gst, compliance, gst',
                'status' => BlogPost::STATUS_PUBLISHED,
            ])
            ->assertRedirect('/admin/blog-posts')
            ->assertSessionHasNoErrors();

        $post = BlogPost::where('title', 'GST Filing Basics')->first();

        $this->assertNotNull($post);
        $this->assertSame('gst-filing-basics', $post->slug);
        $this->assertSame(['gst', 'compliance'], $post->tags);
        $this->assertNotNull($post->published_at);
    }

    public function test_blog_post_status_must_be_valid(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/blog-posts', [
                'title' => 'Bad Status',
                'status' => 'archived',
            ])
            ->assertSessionHasErrors('status');
    }

    public function test_blog_post_create_and_edit_pages_render(): void
    {
        $post = BlogPost::factory()->create();

        $this->actingAs($this->admin())
            ->get('/admin/blog-posts/create')
            ->assertOk();

        $this->actingAs($this->admin())
            ->get("/admin/blog-posts/{$post->slug}/edit")
            ->assertOk();
    }
}

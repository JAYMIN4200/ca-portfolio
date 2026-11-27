<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardVisitsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_counts_each_ip_only_once_for_today_and_total(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        Visit::create(['ip_address' => '10.0.0.1', 'user_agent' => 'Test', 'url' => route('home')]);
        Visit::create(['ip_address' => '10.0.0.1', 'user_agent' => 'Test', 'url' => route('about')]);
        Visit::create(['ip_address' => '10.0.0.2', 'user_agent' => 'Test', 'url' => route('home')]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertViewHas('stats.visits_today', 2)
            ->assertViewHas('stats.visits_total', 2);
    }

    public function test_frontend_visit_by_an_authenticated_user_records_their_user_id(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'name' => 'Named Visitor']);

        $this->actingAs($admin)
            ->get(route('home'))
            ->assertOk();

        $this->assertDatabaseHas('visits', ['user_id' => $admin->id]);
    }

    public function test_dashboard_shows_the_name_of_an_identified_visitor(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Visit::create([
            'ip_address' => '10.0.0.3',
            'user_agent' => 'Test',
            'url' => route('home'),
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertSee($admin->name);
    }

    public function test_dashboard_labels_unidentified_visits_as_guest(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Visit::create(['ip_address' => '10.0.0.4', 'user_agent' => 'Test', 'url' => route('home')]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertSee('Guest')
            ->assertSee('10.0.0.4');
    }
}

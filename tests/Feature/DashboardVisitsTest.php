<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardVisitsTest extends TestCase
{
    use RefreshDatabase;

    public function test_visits_today_counts_each_ip_only_once(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        Visit::create(['ip_address' => '10.0.0.1', 'user_agent' => 'Test', 'url' => route('home')]);
        Visit::create(['ip_address' => '10.0.0.1', 'user_agent' => 'Test', 'url' => route('about')]);
        Visit::create(['ip_address' => '10.0.0.2', 'user_agent' => 'Test', 'url' => route('home')]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertViewHas('stats.visits_today', 2)
            ->assertViewHas('stats.visits_total', 3);
    }
}

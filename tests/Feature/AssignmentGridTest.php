<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignmentGridTest extends TestCase
{
    use RefreshDatabase;

    public function test_assignments_render_in_a_three_column_grid(): void
    {
        $this->seed();

        $this->get('/assignments')
            ->assertOk()
            ->assertSee('sm:grid-cols-2 lg:grid-cols-3', false);
    }
}

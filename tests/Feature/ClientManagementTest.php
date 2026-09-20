<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_guest_is_redirected_from_admin_clients(): void
    {
        $this->get('/admin/clients')->assertRedirect('/admin/login');
    }

    public function test_non_admin_is_forbidden(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => false]))
            ->get('/admin/clients')
            ->assertForbidden();
    }

    public function test_admin_can_view_clients_index(): void
    {
        Client::factory()->count(3)->create();

        $this->actingAs($this->admin())
            ->get('/admin/clients')
            ->assertOk()
            ->assertSee('Clients');
    }

    public function test_admin_can_create_a_client(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/clients', [
                'name' => 'Acme Traders',
                'company' => 'Acme Pvt Ltd',
                'email' => 'hello@acme.test',
                'phone' => '+91 98765 43210',
            ])
            ->assertRedirect('/admin/clients')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('clients', [
            'name' => 'Acme Traders',
            'company' => 'Acme Pvt Ltd',
        ]);
    }

    public function test_client_name_is_required(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/clients', ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    public function test_admin_can_toggle_client_status(): void
    {
        $client = Client::factory()->create(['is_active' => true]);

        $this->actingAs($this->admin())
            ->patch("/admin/clients/{$client->id}/toggle");

        $this->assertFalse($client->fresh()->is_active);
    }

    public function test_admin_can_delete_a_client(): void
    {
        $client = Client::factory()->create();

        $this->actingAs($this->admin())
            ->delete("/admin/clients/{$client->id}");

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

    public function test_admin_can_view_a_client_with_totals(): void
    {
        $client = Client::factory()->create();
        Payment::factory()->create(['client_id' => $client->id, 'amount' => 5000]);
        Payment::factory()->pending()->create(['client_id' => $client->id, 'amount' => 2500]);

        $this->actingAs($this->admin())
            ->get("/admin/clients/{$client->id}")
            ->assertOk()
            ->assertSee($client->name);
    }

    public function test_client_create_page_renders(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/clients/create')
            ->assertOk();
    }

    public function test_admin_can_export_clients_as_csv(): void
    {
        Client::factory()->create(['name' => 'Exportable Client']);

        $response = $this->actingAs($this->admin())
            ->get('/admin/clients/export/csv');

        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('content-type'));
        $this->assertStringContainsString('Exportable Client', $response->streamedContent());
    }

    public function test_admin_can_export_clients_as_xlsx(): void
    {
        Client::factory()->create(['name' => 'Exportable Client']);

        $this->actingAs($this->admin())
            ->get('/admin/clients/export/xlsx')
            ->assertOk()
            ->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_admin_can_download_client_invoice_pdf(): void
    {
        $client = Client::factory()->create(['name' => 'Invoice Client']);
        Payment::factory()->create(['client_id' => $client->id, 'amount' => 5000]);

        $this->actingAs($this->admin())
            ->get("/admin/clients/{$client->id}/invoice")
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_admin_can_filter_clients_by_client_dropdown(): void
    {
        $first = Client::factory()->create(['name' => 'Dropdown Client A']);
        $second = Client::factory()->create(['name' => 'Dropdown Client B']);

        $this->actingAs($this->admin())
            ->get('/admin/clients?client_id='.$first->id)
            ->assertOk()
            ->assertSee('All Clients')
            ->assertSee("/admin/clients/{$first->id}")
            ->assertDontSee("/admin/clients/{$second->id}");
    }

    public function test_admin_can_export_clients_applying_the_client_dropdown_filter(): void
    {
        $first = Client::factory()->create(['name' => 'Filtered Export Client A']);
        Client::factory()->create(['name' => 'Filtered Export Client B']);

        $response = $this->actingAs($this->admin())
            ->get('/admin/clients/export/csv?client_id='.$first->id);

        $response->assertOk();
        $this->assertStringContainsString('Filtered Export Client A', $response->streamedContent());
        $this->assertStringNotContainsString('Filtered Export Client B', $response->streamedContent());
    }
}

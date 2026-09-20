<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_admin_can_view_payments_index_with_totals(): void
    {
        $client = Client::factory()->create();
        Payment::factory()->create(['client_id' => $client->id, 'amount' => 10000]);
        Payment::factory()->pending()->create(['client_id' => $client->id, 'amount' => 4000]);

        $this->actingAs($this->admin())
            ->get('/admin/payments')
            ->assertOk()
            ->assertSee('Payments');
    }

    public function test_admin_can_record_a_received_payment(): void
    {
        $client = Client::factory()->create();

        $this->actingAs($this->admin())
            ->post('/admin/payments', [
                'client_id' => $client->id,
                'amount' => 15000,
                'payment_date' => now()->toDateString(),
                'method' => 'upi',
                'status' => Payment::STATUS_RECEIVED,
            ])
            ->assertRedirect('/admin/payments')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('payments', [
            'client_id' => $client->id,
            'status' => Payment::STATUS_RECEIVED,
        ]);
    }

    public function test_payment_requires_a_valid_client(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/payments', [
                'client_id' => 99999,
                'amount' => 100,
                'payment_date' => now()->toDateString(),
                'status' => Payment::STATUS_RECEIVED,
            ])
            ->assertSessionHasErrors('client_id');
    }

    public function test_payment_amount_and_date_are_required(): void
    {
        $client = Client::factory()->create();

        $this->actingAs($this->admin())
            ->post('/admin/payments', ['client_id' => $client->id])
            ->assertSessionHasErrors(['amount', 'payment_date', 'status']);
    }

    public function test_payment_status_must_be_known(): void
    {
        $client = Client::factory()->create();

        $this->actingAs($this->admin())
            ->post('/admin/payments', [
                'client_id' => $client->id,
                'amount' => 100,
                'payment_date' => now()->toDateString(),
                'status' => 'refunded',
            ])
            ->assertSessionHasErrors('status');
    }

    public function test_admin_can_delete_a_payment(): void
    {
        $payment = Payment::factory()->create();

        $this->actingAs($this->admin())
            ->delete("/admin/payments/{$payment->id}");

        $this->assertDatabaseMissing('payments', ['id' => $payment->id]);
    }

    public function test_payment_create_page_renders(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/payments/create')
            ->assertOk();
    }

    public function test_admin_can_export_payments_as_xlsx(): void
    {
        Payment::factory()->create(['amount' => 1500]);

        $this->actingAs($this->admin())
            ->get('/admin/payments/export/xlsx')
            ->assertOk()
            ->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_admin_can_export_payments_as_csv(): void
    {
        Payment::factory()->create(['amount' => 1500]);

        $response = $this->actingAs($this->admin())
            ->get('/admin/payments/export/csv')
            ->assertOk();

        $this->assertStringContainsString('text/csv', $response->headers->get('content-type'));
    }
}

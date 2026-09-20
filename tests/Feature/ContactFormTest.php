<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_subject_is_required(): void
    {
        $this->post('/contact', [
            'name' => 'Jinendra',
            'email' => 'jinendra@example.com',
            'phone' => '+91 98765 43210',
            'message' => 'This is a valid test message body.',
        ])->assertSessionHasErrors('subject');
    }

    public function test_phone_is_required(): void
    {
        $this->post('/contact', [
            'name' => 'Jinendra',
            'email' => 'jinendra@example.com',
            'subject' => 'GST Compliance',
            'message' => 'This is a valid test message body.',
        ])->assertSessionHasErrors('phone');
    }

    public function test_custom_subject_is_required_when_other_is_selected(): void
    {
        $this->post('/contact', [
            'name' => 'Jinendra',
            'email' => 'jinendra@example.com',
            'phone' => '+91 98765 43210',
            'subject' => 'Other',
            'message' => 'This is a valid test message body.',
        ])->assertSessionHasErrors('subject_other');
    }

    public function test_valid_subject_creates_message(): void
    {
        $this->post('/contact', [
            'name' => 'Jinendra',
            'email' => 'jinendra@example.com',
            'phone' => '+91 98765 43210',
            'subject' => 'GST Compliance',
            'message' => 'This is a valid test message body.',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Jinendra',
            'subject' => 'GST Compliance',
        ]);
    }

    public function test_other_subject_uses_custom_value(): void
    {
        $this->post('/contact', [
            'name' => 'Jinendra',
            'email' => 'jinendra@example.com',
            'phone' => '+91 98765 43210',
            'subject' => 'Other',
            'subject_other' => 'Traineeship Opportunity',
            'message' => 'This is a valid test message body.',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Jinendra',
            'subject' => 'Traineeship Opportunity',
        ]);
    }
}

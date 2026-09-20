<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Ramesh Patel',
                'email' => 'ramesh.patel@example.com',
                'phone' => '+91 98250 12345',
                'subject' => 'GST registration for new business',
                'message' => 'Hello, I am starting a wholesale trading business and would like to know the process and charges for GST registration and monthly return filing. Please share your availability for a call.',
                'is_read' => false,
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya.sharma@example.com',
                'phone' => '+91 99870 45678',
                'subject' => 'Income tax return filing',
                'message' => 'I need help filing my ITR-3 for the last financial year. I have income from freelancing and some capital gains. Could you guide me on the documents required?',
                'is_read' => false,
            ],
            [
                'name' => 'Amit Desai',
                'email' => 'amit.desai@example.com',
                'phone' => '+91 97260 78901',
                'subject' => 'Audit assistance enquiry',
                'message' => 'Our firm requires assistance with a statutory audit for a manufacturing unit during this quarter. We are based in Ahmedabad and prefer on-site support. Kindly share your schedule.',
                'is_read' => true,
            ],
            [
                'name' => 'Sneha Kulkarni',
                'email' => 'sneha.kulkarni@example.com',
                'phone' => '+91 98650 23456',
                'subject' => 'Bookkeeping services',
                'message' => 'We are looking for monthly bookkeeping and MIS reporting services for our retail chain. Can you please share a quote and the engagement terms?',
                'is_read' => true,
            ],
            [
                'name' => 'Vikram Singh',
                'email' => 'vikram.singh@example.com',
                'phone' => '+91 94080 56789',
                'subject' => 'Helping with a GST notice',
                'message' => 'We received a notice regarding ITC mismatch in GSTR-1 and GSTR-3B for the last year. Could you review the notice and help us draft a response?',
                'is_read' => false,
            ],
        ];

        foreach ($messages as $data) {
            ContactMessage::updateOrCreate(
                ['email' => $data['email'], 'subject' => $data['subject']],
                $data
            );
        }
    }
}

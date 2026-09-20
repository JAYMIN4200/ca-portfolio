<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Ramesh Patel',
                'designation' => 'Proprietor',
                'company' => 'Shree Balaji Traders',
                'message' => 'Jinendra has been managing our books of accounts and monthly GST returns for over a year now. He is prompt, accurate and always explains things clearly. Our compliance worries are completely gone.',
                'rating' => 5,
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Priya Shah',
                'designation' => 'Chartered Accountant',
                'company' => 'Shah & Associates',
                'message' => 'Jinendra assisted our firm on statutory audit engagements with a genuinely professional approach. His voucher testing and working paper preparation were meticulous, and he thrived under deadline pressure.',
                'rating' => 5,
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Amit Desai',
                'designation' => 'Director',
                'company' => 'Desai Consultants Pvt Ltd',
                'message' => 'He handled a complex income tax scrutiny response for our company with confidence and great documentation. Proactive communication made the whole process stress-free for our team.',
                'rating' => 4,
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Kiran Joshi',
                'designation' => 'Owner',
                'company' => 'Kiran Textiles',
                'message' => 'From GST registration to monthly returns, everything was handled smoothly. He even recovered eligible input credit we had been missing. Highly recommended for any new business.',
                'rating' => 5,
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Neel Trivedi',
                'designation' => 'Partner',
                'company' => 'Trivedi & Co.',
                'message' => 'A dependable, detail-oriented professional. Jinendra\'s monthly MIS helped our trading firm finally get clear visibility into profitability by product line. Great analytical skills.',
                'rating' => 5,
                'display_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}

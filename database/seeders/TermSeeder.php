<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    public function run(): void
    {
        $terms = [
            [
                'title' => 'Introduction',
                'slug' => 'introduction',
                'content' => 'Welcome to the portfolio website of Jinendra Panchal, a CA Finalist specialising in accounting, audit and taxation. By accessing or using this website, you agree to be bound by the terms and conditions set out below. If you do not agree with any part of these terms, please do not use this website.',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Use of Website',
                'slug' => 'use-of-website',
                'content' => 'The content on this website is provided for general information about the professional experience and services of Jinendra Panchal. You may browse the website for personal, non-commercial purposes. You may not reproduce, distribute or use any content without prior written permission.',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Professional Disclaimer',
                'slug' => 'professional-disclaimer',
                'content' => 'The information presented on this website does not constitute professional advice and must not be relied upon as such. The website owner is a CA Finalist in practice training. Always consult a qualified professional before making financial, tax or legal decisions.',
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Intellectual Property',
                'slug' => 'intellectual-property',
                'content' => 'All text, images, logos and other material on this website are the property of the website owner unless stated otherwise. Unauthorised use, copying or redistribution of this material is prohibited.',
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Third-Party Links',
                'slug' => 'third-party-links',
                'content' => 'This website may contain links to third-party websites such as LinkedIn. These links are provided for convenience only and do not imply endorsement. The website owner is not responsible for the content or practices of external websites.',
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Limitation of Liability',
                'slug' => 'limitation-of-liability',
                'content' => 'The website owner will not be liable for any direct, indirect, incidental or consequential losses arising from the use of, or inability to use, this website or from reliance on the information provided herein.',
                'display_order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Changes to These Terms',
                'slug' => 'changes-to-these-terms',
                'content' => 'These terms and conditions may be updated from time to time. Any changes will be posted on this page, and continued use of the website after such changes constitutes acceptance of the revised terms.',
                'display_order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'content' => 'If you have any questions about these terms, you may reach out through the contact form on this website or by email at jinendrapanchal2002@gmail.com.',
                'display_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($terms as $data) {
            Term::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}

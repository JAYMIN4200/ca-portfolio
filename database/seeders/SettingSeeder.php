<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            'site_name' => ['value' => 'Jinendra Panchal', 'group' => 'general'],
            'site_title' => ['value' => 'Jinendra Panchal | Chartered Accountant', 'group' => 'general'],
            'footer_text' => ['value' => 'Chartered Accountant | Accounting, Audit & Taxation Professional', 'group' => 'general'],
            'copyright' => ['value' => '© '.date('Y').' Jinendra Panchal. All rights reserved.', 'group' => 'general'],
            'logo_text' => ['value' => 'JP', 'group' => 'general'],

            // About — Mission & Vision (dummy)
            'mission' => ['value' => 'To deliver reliable, accurate and ethical financial solutions — from accounting and audit to taxation — so every client can make confident business decisions with complete peace of mind.', 'group' => 'about'],
            'vision' => ['value' => 'To be a trusted financial partner that grows alongside our clients, blending professional expertise with honest, personalised service in accounting, audit and taxation.', 'group' => 'about'],

            // Home — Why Choose Us (dummy)
            'why_choose_us' => ['value' => 'Experienced Team | Qualified professionals with hands-on industry experience.
On-Time Delivery | Deadlines treated as commitments; reports delivered on schedule.
End-to-End Service | From bookkeeping to tax filing, everything under one roof.
Transparent Pricing | Clear, upfront fees with no hidden charges.',
                'group' => 'home'],

            // Contact
            'contact_email' => ['value' => 'jinendrapanchal2002@gmail.com', 'group' => 'contact'],
            'contact_phone' => ['value' => '+91 9979024601', 'group' => 'contact'],
            'contact_location' => ['value' => 'Naroda, Ahmedabad, Gujarat 382230, India', 'group' => 'contact'],

            // About — Mission, Vision, Why Choose Us
            'mission' => ['value' => 'To deliver reliable, transparent and value-driven financial solutions — accounting, audit, taxation and advisory — that let businesses grow with confidence and complete peace of mind.', 'group' => 'about'],
            'vision' => ['value' => 'To be a trusted financial partner that grows alongside our clients, blending professional expertise with honest, personalised service in accounting, audit and taxation.', 'group' => 'about'],
            'why_choose_us' => ['value' => 'Experienced Team | Qualified professionals with hands-on industry experience.
On-Time Delivery | Deadlines treated as commitments, reports delivered on schedule.
End-to-End Coverage | From bookkeeping to tax filing under one roof.
Transparent Pricing | Clear, upfront fees with no hidden charges.', 'group' => 'home'],

            // SEO
            'seo_title' => ['value' => 'Jinendra Panchal | Chartered Accountant, Accounting, Audit & Taxation Professional', 'group' => 'seo'],
            'seo_description' => ['value' => 'Portfolio of Jinendra Panchal, a Chartered Accountant specializing in Accounting, Audit & Taxation.', 'group' => 'seo'],
            'seo_keywords' => ['value' => 'Chartered Accountant, CA, Accounting, Audit, Taxation, GST, Income Tax, Ahmedabad, Gujarat', 'group' => 'seo'],
        ];

        foreach ($settings as $key => $data) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $data['value'], 'group' => $data['group']]
            );
        }
    }
}
